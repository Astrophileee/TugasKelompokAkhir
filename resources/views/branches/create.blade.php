<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            {{ __('Branches') }}
        </h2>
    </x-slot>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title">Add Branch</h2>
            </div>
            <form action="{{ route('branches.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-white">Branch Name</label>
                    <input type="text" name="name" id="name" class="input input-bordered w-full" placeholder="Enter branch name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="location" class="block text-sm font-medium text-white">Branch Location</label>
                    <textarea name="location" id="location" class="input input-bordered w-full" placeholder="Enter branch location" required>value="{{ old('location') }}"</textarea>
                    @error('location')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-success rounded-xl">Add Branch</button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
