<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Dompdf\Dompdf;
use Dompdf\Options;

class TransactionController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        $branchId = '';

        if ($user->hasRole('owner')) {
            $selectedBranch = Branch::find(session('selected_branch_id'));
            $branchId = $selectedBranch->id ?? 'Cabang Tidak Ditemukan';
        } else {
            $branchId = $user->branch->id ?? 'Cabang Tidak Ditemukan';
        }
        $branchId = $branchId;
        $transactions = Transaction::with('user')->where('branch_id', $branchId)->get();
        return view('transactions.index', ['user' => $request->user(), 'transactions' => $transactions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $users = User::all();
        return view('transactions.create', compact('products','users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();
        $branchId = $user->branch_id;

        DB::beginTransaction();
        try {
            $calculatedTotalPrice = collect($validated['products'])->reduce(function ($carry, $item) {
                return $carry + ($item['qty'] * $item['price']);
            }, 0);

            if ($validated['total_price'] != $calculatedTotalPrice) {
                return redirect()->back()->withErrors('Total harga tidak valid.');
            }
            $transaction = Transaction::create([
                'branch_id' => $branchId,
                'user_id' => $user->id,
                'total_price' => $calculatedTotalPrice,
                'date' => now(),
            ]);
            foreach ($validated['products'] as $productData) {
                $product = Product::findOrFail($productData['id']);
                if ($product->stock < $productData['qty']) {
                    throw new \Exception("Stok produk {$product->name} tidak mencukupi.");
                }
                $product->stock -= $productData['qty'];
                $product->save();
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'qty' => $productData['qty'],
                    'unit_price' => $productData['price'],
                ]);
            }

            DB::commit();
            return redirect()->route('transactions.index')->with('success', 'Transaction created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load('transactionDetails');
        return view('transactions.detail', compact('transaction'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        $transaction->load('transactionDetails.product');
        $transaction->load('transactionDetails.product');
        $transactionDetails = $transaction->transactionDetails->map(function ($detail) {
            return [
                'id' => $detail->product->id,
                'code' => $detail->product->code,
                'name' => $detail->product->name,
                'price' => $detail->unit_price,
                'qty' => $detail->qty,
                'total' => $detail->qty * $detail->unit_price,
                'stock' => $detail->product->stock + $detail->qty,
            ];
        });
        return view('transactions.edit', compact('transaction', 'transactionDetails'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTransactionRequest $request, Transaction $transaction)
    {
        $request->validate([
            'products' => 'required|array',
            'total_price' => 'required|numeric',
        ]);
        foreach ($transaction->transactionDetails as $detail) {
            $product = $detail->product;
            if ($product) {
                $product->stock += $detail->qty;
                $product->save();
            }
        }
        $transaction->transactionDetails()->delete();
        foreach ($request->products as $productData) {
            $product = Product::findOrFail($productData['id']);
            $product->stock -= $productData['qty'];
            $product->save();

            $transaction->transactionDetails()->create([
                'product_id' => $productData['id'],
                'qty' => $productData['qty'],
                'unit_price' => $productData['price'],
            ]);
        }
        $transaction->update([
            'total_price' => $request->total_price,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->load('transactionDetails.product');
        if ($transaction->transactionDetails) {
            foreach ($transaction->transactionDetails as $detail) {
                if ($detail->product) {
                    $product = $detail->product;
                    $product->stock += $detail->qty;
                    $product->save();
                }
            }
        }
        $transaction->transactionDetails()->delete();
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaction delete successfully!.');
    }



    public function search(Request $request)
    {
        $term = $request->query('term', '');

        $products = Product::where('name', 'LIKE', "%{$term}%")
            ->orWhere('code', 'LIKE', "%{$term}%")
            ->get(['id', 'name', 'code', 'price', 'stock']);

        return response()->json($products);
    }

    public function generatePDF(Request $request)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        $branchName = '';
        $branchId = null;
        if ($user->hasRole('owner')) {
            $selectedBranch = Branch::find(session('selected_branch_id'));
            $branchName = $selectedBranch->name ?? 'Cabang Tidak Ditemukan';
            $branchId = $selectedBranch->id ?? null;
        } else {
            $branchName = $user->branch->name ?? 'Cabang Tidak Ditemukan';
            $branchId = $user->branch->id ?? null;
        }
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        $transactions = Transaction::where('branch_id', $branchId)
            ->whereBetween('date', [$validated['start_date'], $validated['end_date']])
            ->get();
        if ($transactions->isEmpty()) {
            $message = 'No transactions found in the selected date range.';
        } else {
            $message = null;
        }
        $pdf = FacadePdf::loadView('transactions.pdf', [
            'transactions' => $transactions,
            'branchName' => $branchName,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'message' => $message,
        ]);

        return $pdf->download('transactions_' . $branchName . '_' . $validated['start_date'] . '_to_' . $validated['end_date'] . '.pdf');
    }



    public function generateReceiptPDF($transactionId)
    {
        $transaction = Transaction::with('transactionDetails.product')->findOrFail($transactionId);
        $pdf = FacadePdf::loadView('transactions.detailPdf', [
            'transaction' => $transaction,
        ]);
        $fileName = 'Receipt_' . $transaction->transaction_number . '.pdf';
        return $pdf->download($fileName);
    }




}
