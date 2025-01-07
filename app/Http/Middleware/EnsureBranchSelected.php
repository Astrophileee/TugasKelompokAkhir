<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureBranchSelected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        if ($user->hasRole('owner') && !$request->session()->has('selected_branch_id')) {
            return redirect()->route('branches.select')->with('error', 'Silakan pilih cabang terlebih dahulu.');
        }

        return $next($request);
    }

}
