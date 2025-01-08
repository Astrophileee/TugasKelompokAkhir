<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            {{ __('Add User') }}
        </h2>
    </x-slot>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title">Add User</h2>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-white">Name</label>
                    <input type="text" name="name" id="name" class="input input-bordered w-full" placeholder="Enter name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-white">Email</label>
                    <input type="email" name="email" id="email" class="input input-bordered w-full" placeholder="Enter email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-white">Role</label>
                    <select name="role" id="role" class="input input-bordered w-full" required>
                        <option value="">Select Role</option>
                        @foreach(\Spatie\Permission\Models\Role::all() as $role)
                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div id="branch-container" class="mb-4">
                    <label for="branch_id" class="block text-sm font-medium text-white">Branch</label>
                    <select name="branch_id" id="branch_id" class="input input-bordered w-full">
                        <option value="">Select Branch</option>
                        @foreach(\App\Models\Branch::all() as $branch)
                        <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    @error('branch_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-white">Password</label>
                    <input type="password" name="password" id="password" class="input input-bordered w-full" placeholder="Enter password" required>
                    @error('password')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-white">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="input input-bordered w-full" placeholder="Confirm password" required>
                    @error('password_confirmation')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn btn-success rounded-xl">Add User</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role');
            const branchContainer = document.getElementById('branch-container');
            const branchSelect = document.getElementById('branch_id');
            function toggleBranchField() {
                if (roleSelect.value === 'owner' || roleSelect.value === 'admin') {
                    branchContainer.style.display = 'none';
                    branchSelect.removeAttribute('required');
                    branchSelect.value = '';
                } else {
                    branchContainer.style.display = 'block';
                    branchSelect.setAttribute('required', 'required');
                }
            }
            roleSelect.addEventListener('change', toggleBranchField);
            toggleBranchField();
        });
    </script>
</x-app-layout>
