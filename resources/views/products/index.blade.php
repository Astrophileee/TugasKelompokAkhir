<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="card bg-base-100 shadow-xl">
    <div class="card-body">
        <div class="flex justify-between items-center mb-4">
            <h2 class="card-title">Product List</h2>
            <div class="flex gap-2">
                @hasanyrole('manager|stocker')
                    <a href="{{ route('products.create') }}">
                        <button class="btn btn-success flex items-center rounded-md">
                            <i class="fas fa-plus"></i>
                            Tambah
                        </button>
                    </a>
                @endhasanyrole
                @hasanyrole('manager|owner|supervisor')
                    <form action="{{ route('products.pdf') }}" method="GET" class="flex gap-2">
                        <input type="date" name="start_date" class="input input-bordered" required />
                        <input type="date" name="end_date" class="input input-bordered" required />
                        <button type="submit" class="btn btn-error flex items-center rounded-md">
                            <i class="fa-solid fa-file-pdf"></i>
                            Print PDF
                        </button>
                    </form>
                @endhasanyrole
            </div>
        </div>
        <div class="overflow-x-auto">
            <table id="tableProduct" class="table table-zebra datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Last Updated</th> <!-- Kolom untuk updated_at -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product )
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ strtoupper($product->code) }}</td>
                        <td>{{ ucwords($product->name) }}</td>
                        <td>Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->updated_at->format('Y-m-d') }}</td> <!-- Format tanggal -->
                        <td>
                            <div class="flex space-x-2">
                                @hasanyrole('manager|stocker')
                                <a href="{{ route('products.edit', $product) }}">
                                    <button class="text-blue-600 hover:text-blue-900 border border-blue-600 rounded-md px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                                        Edit
                                    </button>
                                </a>
                                <form id="deleteForm{{ $product->id }}" action="{{ route('products.destroy', $product) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            onclick="confirmDelete('{{ $product->id }}')"
                                            class="text-red-600 hover:text-red-900 border border-red-600 rounded-md px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-200">
                                        Delete
                                    </button>
                                </form>
                                @endhasanyrole
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function confirmDelete(productId) {
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
                document.getElementById('deleteForm' + productId).submit();
            }
        });
    }
</script>

</x-app-layout>
