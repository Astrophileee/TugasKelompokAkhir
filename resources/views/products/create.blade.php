@php
    use App\Models\Branch;
    /** @var \App\Models\User */
    $user = Auth::user();
        $branchId = '';

        if ($user->hasRole('owner')) {
            $selectedBranch = Branch::find(session('selected_branch_id'));
            $branchId = $selectedBranch->id ?? 'Cabang Tidak Ditemukan';
        } else {
            $branchId = $user->branch->id ?? 'Cabang Tidak Ditemukan';
        }
        $branchId = $branchId;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title">Add Product</h2>
            </div>
            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <input type="hidden" name="branch_id" value="{{ $branchId }}">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-white">Product Name</label>
                    <input type="text" name="name" id="name" class="input input-bordered w-full" placeholder="Enter product name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="code" class="block text-sm font-medium text-white">Product Code</label>
                    <input type="text" name="code" id="code" class="input input-bordered w-full" placeholder="Enter product name" value="{{ old('code') }}" required>
                    @error('code')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="stock" class="block text-sm font-medium text-white">Stock</label>
                    <input type="number" name="stock" id="stock" class="input input-bordered w-full" placeholder="Enter product stock" value="{{ old('stock') }}" required min="0">
                    @error('stock')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-white">Price</label>
                    <input type="text" name="price" id="price" class="input input-bordered w-full" placeholder="Enter product price" value="{{ old('price') }}" required>
                    @error('price')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-success rounded-xl">Add Product</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const priceInput = document.getElementById('price');

        priceInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            let formattedValue = formatRupiah(value);
            e.target.value = formattedValue;
        });
        function formatRupiah(value) {
            let valueString = value.toString();
            let split = valueString.split('');
            let result = '';
            let count = 0;
            for (let i = split.length - 1; i >= 0; i--) {
                count++;
                result = split[i] + result;
                if (count % 3 === 0 && i !== 0) {
                    result = '.' + result;
                }
            }
            return result ? 'Rp. ' + result : '';
        }
        const form = document.querySelector('form');
        form.addEventListener('submit', function () {
            const price = document.getElementById('price');
            price.value = price.value.replace(/[^0-9]/g, '');
        });
    </script>

</x-app-layout>
