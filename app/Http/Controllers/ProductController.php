<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Branch;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
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
        $products = product::with(['branches'])->where('branch_id', $branchId)->get();
        return view('products.index',['user' => $request->user(),'products'=>$products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $branches = Branch::all();
        return view('products.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['price'] = str_replace(['Rp.', '.'], '', $validatedData['price']);
        Product::create($validatedData);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product){


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        return view('products.edit',['product' => $product,'branches'=> Branch::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validatedData = $request->validated();
        $product->update($validatedData);
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->transactions()->exists()) {
            return redirect()->route('products.index')->with('error', 'Product cannot be deleted because they are associated with transactions.');
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
