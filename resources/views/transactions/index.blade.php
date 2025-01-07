<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            {{ __('Transactions') }}
        </h2>
    </x-slot>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Transaction History</h2>
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>1</td>
                            <td>2024-01-07</td>
                            <td>Rp. 99.000</td>
                            <td><span class="badge badge-success">Completed</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>