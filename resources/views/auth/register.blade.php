<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="w-full sm:max-w-md mt-2 px-6 py-3 bg-white overflow-hidden sm:rounded-t-lg">
            <div class="flex flex-col items-center">
                <h1 class="text-3xl font-bold text-gray-900">Market Kel4</h1>
            </div>
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="">Select Role</option>
                @foreach(\Spatie\Permission\Models\Role::all() as $role)
                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Branch ID -->
        <div id="branch-container" class="mt-4">
            <x-input-label for="branch_id" :value="__('Branch')" class="text-black" />
            <select id="branch_id" name="branch_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">Select Branch</option>
                @foreach(\App\Models\Branch::all() as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('branch_id')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role');
            const branchContainer = document.getElementById('branch-container');
            const branchSelect = document.getElementById('branch_id');

            // Fungsi untuk menyembunyikan atau menampilkan field branch
            function toggleBranchField() {
                if (roleSelect.value === 'owner' || roleSelect.value === 'admin') {
                    branchContainer.style.display = 'none'; // Sembunyikan field branch
                    branchSelect.removeAttribute('required'); // Hapus validasi required
                    branchSelect.value = ''; // Reset value
                } else {
                    branchContainer.style.display = 'block'; // Tampilkan field branch
                    branchSelect.setAttribute('required', 'required'); // Tambahkan validasi required
                }
            }

            // Event listener untuk perubahan nilai pada dropdown role
            roleSelect.addEventListener('change', toggleBranchField);

            // Inisialisasi saat halaman dimuat
            toggleBranchField();
        });
    </script>

</x-guest-layout>
