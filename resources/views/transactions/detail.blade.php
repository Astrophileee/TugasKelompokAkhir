<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            {{ __('Detail Transaksi') }}
        </h2>
    </x-slot>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h4 class="text-lg font-semibold">Informasi Transaksi</h4>
            <div class="mb-4">
                <p><strong>Number Transaksi:</strong> {{ $transaction->transaction_number }}</p>
                <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d-m-Y H:i') }}</p>
                <p><strong>Total Harga:</strong> Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
            </div>
            <h4 class="text-lg font-semibold">Detail Barang</h4>
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaction->transactionDetails as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ strtoupper($detail->product->code) }}</td>
                            <td>{{ $detail->product->name }}</td>
                            <td>Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                            <td>{{ $detail->qty }}</td>
                            <td>Rp {{ number_format($detail->unit_price * $detail->qty, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500">Tidak ada barang dalam transaksi ini</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
