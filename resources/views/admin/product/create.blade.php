@extends('layouts.adminlayout')

@section('content')

<div class="my-6">
    <h1 class="text-2xl font-semibold mb-4">Create New Product</h1>

    <div x-data="{ activeTab: 'home' }">
        <!-- Tabs navigation -->
        <ul class="flex mb-4">
            <li class="mr-1">
                <a href="#" @click.prevent="activeTab = 'home'" :class="{ 'bg-blue-500 text-white': activeTab === 'home', 'border': activeTab !== 'home' }" class="block px-4 py-2 rounded-lg hover:bg-blue-500 hover:text-white">Home</a>
            </li>
            <li class="mr-1">
                <a href="#" @click.prevent="activeTab = 'seo'" :class="{ 'bg-blue-500 text-white': activeTab === 'seo', 'border': activeTab !== 'seo' }" class="block px-4 py-2 rounded-lg hover:bg-blue-500 hover:text-white">SEO Tag</a>
            </li>
            <li class="mr-1">
                <a href="#" @click.prevent="activeTab = 'detail'" :class="{ 'bg-blue-500 text-white': activeTab === 'detail', 'border': activeTab !== 'detail' }" class="block px-4 py-2 rounded-lg hover:bg-blue-500 hover:text-white">Detail</a>
            </li>
            <li class="mr-1">
                <a href="#" @click.prevent="activeTab = 'images'" :class="{ 'bg-blue-500 text-white': activeTab === 'images', 'border': activeTab !== 'images' }" class="block px-4 py-2 rounded-lg hover:bg-blue-500 hover:text-white">Product Image</a>
            </li>
            <li class="mr-1">
                <a href="#" @click.prevent="activeTab = 'colors'" :class="{ 'bg-blue-500 text-white': activeTab === 'colors', 'border': activeTab !== 'colors' }" class="block px-4 py-2 rounded-lg hover:bg-blue-500 hover:text-white">Colors</a>
            </li>
        </ul>

        <!-- Tabs content -->
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        <div>
            <!-- Home Tab -->
            <div x-show="activeTab === 'home'">
                    @csrf

                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Select Category</label>
                        <select name="category_id" id="category" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="slug" class="block text-sm font-medium text-gray-700">Product Slug</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                        @error('slug')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="brand" class="block text-sm font-medium text-gray-700">Select Brand</label>
                        <select name="brand" id="brand" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @error('brand')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="small_description" class="block text-sm font-medium text-gray-700">Small Description</label>
                        <textarea name="small_description" id="small_description" rows="4" class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">{{ old('small_description') }}</textarea>
                        @error('small_description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4" class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                        @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
            </div>

            <!-- SEO Tab -->
            <div x-show="activeTab === 'seo'">


                    <div class="mb-4">
                        <label for="meta_title" class="block text-sm font-medium text-gray-700">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}" class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                        @error('meta_title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="meta_description" class="block text-sm font-medium text-gray-700">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="4" class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">{{ old('meta_description') }}</textarea>
                        @error('meta_description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="meta_keyword" class="block text-sm font-medium text-gray-700">Meta Keywords</label>
                        <input type="text" name="meta_keyword" id="meta_keyword" value="{{ old('meta_keyword') }}" class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                        @error('meta_keyword')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
            </div>

            <!-- Detail Tab -->
            <div x-show="activeTab === 'detail'">
                    <div class="mb-4">
                        <label for="original_price" class="block text-sm font-medium text-gray-700">Original Price</label>
                        <input type="number" name="original_price" id="original_price" value="{{ old('original_price') }}" class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                        @error('original_price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="selling_price" class="block text-sm font-medium text-gray-700">Selling Price</label>
                        <input type="number" name="selling_price" id="selling_price" value="{{ old('selling_price') }}" class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                        @error('selling_price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex mb-4 items-center">
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mr-4">Quantity</label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" class="px-3 py-2 block w-24 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                        @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <fieldset>
                            <legend class="block text-sm font-medium text-gray-700 mb-2">Trending</legend>
                            <div class="flex items-center">
                                <input type="checkbox" id="trending" name="trending" value="1" class="form-checkbox h-4 w-4 text-blue-500 focus:ring-blue-500">
                                <label for="trending" class="ml-2 block text-sm text-gray-900"></label>
                            </div>
                        </fieldset>
                    </div>

                    <div class="mb-4">
                        <fieldset>
                            <legend class="block text-sm font-medium text-gray-700 mb-2">Status</legend>
                            <div class="flex items-center">
                                <input type="checkbox" id="status" name="status" value="1" class="form-checkbox h-4 w-4 text-blue-500 focus:ring-blue-500">
                                <label for="status" class="ml-2 block text-sm text-gray-900"></label>
                            </div>
                        </fieldset>
                    </div>
            </div>

            <!-- Images Tab -->
            <div x-show="activeTab === 'images'">

                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700">Product Images</label>
                        <input type="file" name="images[]" id="image" multiple class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                        @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
            </div>
        </div>

        <!-- Colors Tab -->
        <div x-show="activeTab === 'colors'">
            <div class="mb-4">
                <fieldset>
                    <legend class="block text-sm font-medium text-gray-700 mb-2">Select Colors</legend>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($colors as $color)
                        <div class="flex items-center">
                            <input type="checkbox" name="colors[{{ $color->id }}]" value="{{ $color->id }}" class="form-checkbox h-4 w-4 text-blue-500 focus:ring-blue-500">
                            <label for="color_{{ $color->id }}" class="ml-2 block text-sm text-gray-900">{{ $color->name }}</label>
                            <input type="number" name="color_quantity[{{ $color->id }}]" placeholder="qty" class="ml-4 block w-24 px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        @endforeach
                    </div>
                </fieldset>
                @error('colors')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded inline-block mt-4">Submit</button>

    </div>
</div>

@endsection
