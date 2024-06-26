@extends('layouts.adminlayout')

@section('content')
    <div class="my-6">
        <h1 class="text-2xl font-semibold mb-4">Add New Slider</h1>

        <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" name="image" id="image" class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
             </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <div class="flex items-center">
                    <input type="checkbox" id="status" name="status[]" value="status" class="form-checkbox h-4 w-4 text-blue-500 focus:ring-blue-500" {{ old('status') ? 'checked' : '' }}>
                    <label for="status" class="ml-2 block text-sm text-gray-900">Status</label>
                </div>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded inline-block">Create Category</button>
            </div>
        </form>
    </div>
@endsection


