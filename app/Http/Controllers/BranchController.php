<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
        $validatedData = $request->validate();
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
        $validatedData = $request->validate();
        $branch->update($validatedData);
        return redirect()->route('branches.index')->with('success','Branch updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('branches.index')->with('success','Branch deleted successfully!');
    }
}
