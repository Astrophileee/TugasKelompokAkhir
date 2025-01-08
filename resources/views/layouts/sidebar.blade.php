<div class="drawer-side">
    <label for="my-drawer-2" class="drawer-overlay"></label>
    <aside class="bg-black w-80 min-h-screen text-gray-300">
        <div class="p-4 bg-primary text-primary-content">
            <a href="{{ route('dashboard') }}" class="text-2xl font-bold">
                Market PWL
            </a>
        </div>
        <ul class="menu p-4">
            <li>
                @php
                    use Illuminate\Support\Facades\Auth;
                    use App\Models\Branch;

                    $user = Auth::user();
                    $branchName = '';
                    $roleName = $user->roles->pluck('name')->map(fn($role) => ucwords($role))->join(', ');

                    if ($user->hasRole('owner')) {
                        $selectedBranch = Branch::find(session('selected_branch_id'));
                        $branchName = $selectedBranch->name ?? 'Cabang Tidak Ditemukan';
                    } elseif ($user->hasRole('admin')) {
                        $branchName = 'Admin - Tidak Perlu Cabang';
                    } else {
                        $branchName = $user->branch->name ?? 'Cabang Tidak Ditemukan';
                    }
                @endphp

                <div>
                    Cabang: {{ $branchName }}
                </div>
                <div class="">
                    Role : {{ $roleName }}
                </div>

            </li>
            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i>
                    Dashboard
                </a>
            </li>
            <!-- Branches -->
            @hasanyrole('admin|owner')
            <li>
                <a href="{{ route('branches.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i>
                    Branches
                </a>
            </li>
            @endhasanyrole
            <!-- Users -->
            @hasanyrole('admin|owner')
            <li>
                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('branches.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-code-branch"></i>
                    Users
                </a>
            </li>
            @endhasanyrole
            <!-- Products -->
            @hasanyrole('owner|stocker|manager|supervisor')
            <li>
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-box"></i>
                    Products
                </a>
            </li>
            @endhasanyrole
            @hasanyrole('owner|cashier|manager|supervisor')
            <!-- Transactions with Submenu -->
            <li class="relative">
                <input type="checkbox" id="menu-transactions" class="peer hidden">
                <label for="menu-transactions" class="flex justify-between items-center cursor-pointer">
                    <span>
                        <i class="fa-solid fa-cart-shopping"></i>
                        Transactions
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 peer-checked:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </label>
                <ul class="hidden peer-checked:block ml-5 mt-2 space-y-2">
                    @hasanyrole('cashier|manager|supervisor')
                    <li>
                        <a href="{{ route('transactions.create') }}" class="{{ request()->routeIs('transactions.create') ? 'active' : '' }}">
                            <i class="fa-solid fa-cash-register"></i>
                            Transaction
                        </a>
                    </li>
                    @endhasanyrole
                    @hasanyrole('owner|cashier|manager|supervisor')
                    <li>
                        <a href="{{ route('transactions.index') }}" class="{{ request()->routeIs('transactions.index') ? 'active' : '' }}">
                            <i class="fa-solid fa-file-invoice"></i>
                            Report Transaction
                        </a>
                    </li>
                    @endhasanyrole
                </ul>
            </li>
            @endhasanyrole
            @hasanyrole('owner')
            <li>
                <a href="{{ route('branches.select') }}">
                    <i class="fa-solid fa-chevron-left"></i>
                    Switch Branch
                </a>
            </li>
            @endhasanyrole
        </ul>
    </aside>
</div>
