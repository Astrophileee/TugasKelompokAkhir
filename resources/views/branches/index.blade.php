<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            {{ __('Branches') }}
        </h2>
    </x-slot>

    <div class="card bg-base-100 shadow-xl">
    <div class="card-body">
        <div class="flex justify-between items-center mb-4">
            <h2 class="card-title">Branches List</h2>
            <div class="flex gap-2">
                    <a href="{{ route('branches.create') }}">
                        <button class="btn btn-success flex items-center rounded-md">
                            <i class="fas fa-plus"></i>
                            Tambah
                        </button>
                    </a>
                @hasanyrole('owner')
                    <a href="{{ route('branches.pdf') }}">
                        <button class="btn btn-error flex items-center rounded-md">
                            <i class="fa-solid fa-file-pdf"></i>
                            Print PDF
                        </button>
                    </a>
                @endhasanyrole
            </div>
        </div>
        <div class="overflow-x-auto">
            <table id="tableBranches" class="table table-zebra datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($branches as $branch )
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $branch->name }}</td>
                        <td>{{ $branch->location }}</td>
                        <td>
                            <div class="flex space-x-2">
                                <a href="{{ route('branches.edit', $branch) }}">
                                    <button class="text-blue-600 hover:text-blue-900 border border-blue-600 rounded-md px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                                        Edit
                                    </button>
                                </a>
                                @hasanyrole('owner')
                                <form id="deleteForm{{ $branch->id }}" action="{{ route('branches.destroy', $branch) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            onclick="confirmDelete('{{ $branch->id }}')"
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
    function confirmDelete(branchId) {
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
                document.getElementById('deleteForm' + branchId).submit();
            }
        });
    }
</script>

</x-app-layout>
