<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            {{ __('Transactions') }}
        </h2>
    </x-slot>

    <div class="card bg-base-100 shadow-xl">
    <div class="card-body">
        <div class="flex justify-between items-center mb-4">
            <h2 class="card-title">Transactions List</h2>
            <span></span>
            @hasanyrole('cashier|manager|supervisor')
                <a href="{{ route('transactions.create') }}">
                    <button class="btn btn-success flex items-center rounded-md">
                        <i class="fas fa-plus"></i>
                        Tambah
                    </button>
                </a>
            @endhasanyrole
        </div>

        <div class="overflow-x-auto">
            <table id="tableBranches" class="table table-zebra datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Transaction Number</th>
                        <th>Cashier</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandTotal = 0;
                    @endphp
                    @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $transaction->transaction_number }}</td>
                        <td>{{ $transaction->user->name }}</td>
                        <td>{{ $transaction->date }}</td>
                        <td>Rp. {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                        <td>
                            <div class="flex space-x-2">
                                <a href="{{ route('transactions.detail', $transaction) }}">
                                    <button class="text-accent hover:text-blue-900 border border-accent rounded-md px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                                        Detail
                                    </button>
                                </a>
                                @hasanyrole('cashier|manager|owner')
                                <a href="{{ route('transactions.edit', $transaction) }}">
                                    <button class="text-info hover:text-blue-900 border border-info rounded-md px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                                        Edit
                                    </button>
                                </a>
                                @endhasanyrole
                                @hasanyrole('manager|owner')
                                <form id="deleteForm{{ $transaction->id }}" action="{{ route('transactions.destroy', $transaction) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            onclick="confirmDelete('{{ $transaction->id }}')"
                                            class="text-error hover:text-red-900 border border-error rounded-md px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-200">
                                        Delete
                                    </button>
                                </form>
                                @endhasanyrole
                            </div>
                        </td>
                    </tr>
                    @php
                        $grandTotal += $transaction->total_price;
                    @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right font-bold">Grand Total:</td>
                        <td class="font-bold">Rp. {{ number_format($grandTotal, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>


<script>
function confirmDelete(transactionId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteForm' + transactionId);
            if (form) {
                form.submit();
            } else {
                console.error('Form not found for transaction ID:', transactionId);
            }
        }
    });
}




</script>

</x-app-layout>
