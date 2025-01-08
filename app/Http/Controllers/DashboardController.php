<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        if ($user->hasRole('owner')) {
            $branchId = session('selected_branch_id');
        } else {
            $branchId = $user->branch_id;
        }

        $data = [
            'users_count' => User::where('branch_id', $branchId)->count(),
            'products_count' => Product::where('branch_id', $branchId)->count(),
            'branches_count' => Branch::count(),
            'transactions_count' => Transaction::where('branch_id', $branchId)->count(),
            'transaction_products_count' => TransactionDetail::whereHas('transaction', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            })->count(),
            'totalQty' => TransactionDetail::whereHas('transaction', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            })->sum('qty'),
            'user' => $user,
        ];

        return view('dashboard', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
