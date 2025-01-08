<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $users = User::with(['branch', 'roles'])->get();
        return view('users.index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $branches = Branch::all();
        $roles = Role::all();

        return view('users.create', compact('branches', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'branch_id' => $request->branch_id,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User created successfully!');

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
    public function edit(User $user)
    {
        $roles = Role::all();
        $branches = Branch::all();
        return view('users.edit', compact('user', 'roles', 'branches'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        $user->syncRoles($request->role);
        $user->update($validated);
        return redirect()->route('users.index')->with('success', 'User update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->transactions()->exists()) {
            return redirect()->route('users.index')->with('error', 'User cannot be deleted because they are associated with transactions.');
        }
        if (Auth::id() === $user->id) {
            Auth::logout();
            $user->delete();
            return redirect()->route('login');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function generatePDF(){

        $branches = Branch::all();
        $users = User::all();
        $roles = Role::all();

        $pdf = FacadePdf::loadView('users.pdf', [
            'users' => $users,
            'branches' => $branches,
            'roles' => $roles
        ]);

        return $pdf->download('All_User'. '.pdf');

    }
}
