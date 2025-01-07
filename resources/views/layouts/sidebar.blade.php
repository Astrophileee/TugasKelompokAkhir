<div class="drawer-side">
    <label for="my-drawer-2" class="drawer-overlay"></label>
    <aside class="bg-black w-80 min-h-screen text-gray-300">
        <div class="p-4 bg-primary text-primary-content">
            <a href="{{ route('dashboard') }}" class="text-2xl font-bold">
                Market PWL
            </a>
        </div>
        <ul class="menu p-4">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
            </li>
            <!-- Products -->
            <li>
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Products
                </a>
            </li>
            <!-- Transactions with Submenu -->
            <li class="relative">
                <input type="checkbox" id="menu-transactions" class="peer hidden">
                <label for="menu-transactions" class="flex justify-between items-center cursor-pointer">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Transactions
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 peer-checked:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </label>
                <ul class="hidden peer-checked:block ml-5 mt-2 space-y-2">
                    <li>
                        <a href="{{ route('transactions.index') }}" class="{{ request()->routeIs('transactions.index') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 2L18 2L18 22L6 22zM6 2L18 12L6 22" />
                            </svg>
                            Detail Transaksi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6L8 10L12 6M16 10L12 14L8 10" />
                        </svg>
                            Laporan Transaksi
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
