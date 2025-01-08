<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $branches = Branch::all();
        return view('branches.index',['user' => $request->user(),'branches' => $branches]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        return view('branches.create', ['user' => $request->user()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBranchRequest $request)
    {
        $validatedData = $request->validated();
        Branch::create($validatedData);
        return redirect()->route('branches.index')->with('success','Branch added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        return view('branches.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBranchRequest $request, Branch $branch)
    {
        $validatedData = $request->validated();
        $branch->update($validatedData);
        return redirect()->route('branches.index')->with('success','Branch updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        if ($branch->transactions()->exists()) {
            return redirect()->route('branches.index')->with('error', 'Branch cannot be deleted because they are associated with transactions.');
        }

        if ($branch->products()->exists()) {
            return redirect()->route('branches.index')->with('error', 'Branch cannot be deleted because they are associated with products.');
        }
        if ($branch->users()->exists()) {
            return redirect()->route('branches.index')->with('error', 'Branch cannot be deleted because they are associated with users.');
        }
        $branch->delete();
        return redirect()->route('branches.index')->with('success','Branch deleted successfully!');
    }
    public function select()
    {
        $branches = Branch::all();

        return view('branches.select', compact('branches'));
    }

    /**
     * Menyimpan cabang yang dipilih ke dalam sesi.
     */
    public function storeSelection($id, Request $request)
    {
        $branch = Branch::find($id);
        if (!$branch) {
            return redirect()->route('branches.select')->with('error', 'Cabang tidak ditemukan.');
        }
        $request->session()->put('selected_branch_id', $branch->id);
        return redirect()->route('dashboard')->with('success', 'Cabang berhasil dipilih!');
    }

    public function generatePDF(){

        $branches = Branch::all();

        $pdf = FacadePdf::loadView('branches.pdf', [
            'branches' => $branches
        ]);

        return $pdf->download('All_Branch'. '.pdf');

    }
}
