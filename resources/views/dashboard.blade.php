<x-app-layout>
    <h2 class="font-semibold text-xl">
        {{ __('Dashboard') }}
    </h2>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-base-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-base-content">
                    {{ __("Anda Sudah Login!") }}
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <!-- Total Users -->
                    <div class="card border border-secondary shadow-md rounded-xl p-4">
                        <div class="card-body text-center">
                            <div class="text-secondary mb-3">
                                <i class="fa-solid fa-users text-4xl"></i>
                            </div>
                            <h3 class="text-lg font-bold">Jumlah Users</h3>
                            <p class="text-xl font-semibold text-accent">
                                {{ number_format($data['users_count']) }}
                            </p>
                        </div>
                    </div>

                    <!-- Total Products -->
                    <div class="card border border-secondary shadow-md rounded-xl p-4">
                        <div class="card-body text-center">
                            <div class="text-secondary mb-3">
                                <i class="fa-solid fa-box text-4xl"></i>
                            </div>
                            <h3 class="text-lg font-bold">Jumlah Products</h3>
                            <p class="text-xl font-semibold text-accent">
                                {{ number_format($data['products_count']) }}
                            </p>
                        </div>
                    </div>

                    <!-- Total Products in Transactions -->
                    <div class="card border border-secondary shadow-md rounded-xl p-4">
                        <div class="card-body text-center">
                            <div class="text-secondary mb-3">
                                <i class="fa-solid fa-cart-shopping text-4xl"></i>
                            </div>
                            <h3 class="text-lg font-bold">Jumlah Product Yang Terjual</h3>
                            <p class="text-xl font-semibold text-accent">
                                {{ number_format($data['transaction_products_count']) }}
                            </p>
                        </div>
                    </div>

                    <!-- Total qty Products in Transactions -->
                    <div class="card border border-secondary shadow-md rounded-xl p-4">
                        <div class="card-body text-center">
                            <div class="text-secondary mb-3">
                                <i class="fa-solid fa-boxes-stacked text-4xl"></i>
                            </div>
                            <h3 class="text-lg font-bold">Jumlah Kuantitas Product Yang Terjual</h3>
                            <p class="text-xl font-semibold text-accent">
                                {{ number_format($data['totalQty']) }}
                            </p>
                        </div>
                    </div>

                    <!-- Total Branches -->
                    <div class="card border border-secondary shadow-md rounded-xl p-4">
                        <div class="card-body text-center">
                            <div class="text-secondary mb-3">
                                <i class="fa-solid fa-shop text-4xl"></i>
                            </div>
                            <h3 class="text-lg font-bold">Jumlah Branches</h3>
                            <p class="text-xl font-semibold text-accent">
                                {{ number_format($data['branches_count']) }}
                            </p>
                        </div>
                    </div>

                    <!-- Total Transactions -->
                    <div class="card border border-secondary shadow-md rounded-xl p-4">
                        <div class="card-body text-center">
                            <div class="text-secondary mb-3">
                                <i class="fa-solid fa-credit-card text-4xl"></i>
                            </div>
                            <h3 class="text-lg font-bold">Jumlah Transactions</h3>
                            <p class="text-xl font-semibold text-accent">
                                {{ number_format($data['transactions_count']) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
