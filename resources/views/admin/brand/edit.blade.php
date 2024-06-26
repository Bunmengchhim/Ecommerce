@extends('layouts.adminlayout')

@section('content')
    <div class="my-6">
        <h1 class="text-2xl font-semibold mb-4">Brands Category</h1>

        <form action="{{ route('brand.update', $brands->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $brands->name) }}" class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $brands->slug) }}" class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                @error('slug')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <div class="flex items-center">
                    <input type="checkbox" id="status" name="status" value="1" class="form-checkbox h-4 w-4 text-blue-500 focus:ring-blue-500" {{ old('status', $brands->status) == '1' ? 'checked' : '' }}>
                    <label for="status" class="ml-2 block text-sm text-gray-900">Status</label>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded inline-block">Update Category</button>
            </div>
        </form>
    </div>

    
@endsection
