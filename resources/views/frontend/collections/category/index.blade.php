@extends('layouts.app')

@section('content')

<div class="py-12">
    <div class="container mx-auto">
        <div class="text-center mb-8">
            <h4 class="text-2xl font-semibold text-gray-800">Our Categories</h4>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($categories as $category)
            <div class="category-card bg-white shadow-md rounded-lg overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-lg">
                <a href="{{ url('/collections/' .$category->slug) }}">
                    <div class="category-card-img">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" class="w-full h-64 object-cover" alt="{{ $category->name }}">
                        @else
                            <img src="default-image.jpg" class="w-full h-64 object-cover" alt="{{ $category->name }}">
                        @endif
                    </div>
                    <div class="category-card-body p-4">
                        <h5 class="text-lg font-semibold text-gray-900 text-center">{{ $category->name }}</h5>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>



@endsection