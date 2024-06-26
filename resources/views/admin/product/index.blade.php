@extends('layouts.adminlayout')

@section('content')

<div class="my-6">
    <h1 class="text-2xl font-semibold mb-4">Products</h1>
    <div class="flex justify-between items-center mb-4 space-x-4">
        <form method="GET" action="" class="flex items-center space-x-4 flex-grow">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name" class="form-input w-1/3">
            <select name="status" class="form-select w-1/4">
                <option value="">All</option>
                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md transition duration-200">Filter</button>
        </form>
        <a href="{{ route('product.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md transition duration-200">Add New Product</a>
    </div>

    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false,
                background: '#f9fafb',
                padding: '0.5rem',
                customClass: {
                    popup: 'border border-gray-300 rounded-lg shadow-lg',
                    title: 'text-lg font-semibold',
                    content: 'text-sm text-gray-700',
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
        });
    </script>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border-collapse border border-gray-200 shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
                <tr class="bg-gray-100 border-b border-gray-300">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($products as $product)
                    <tr id="product-{{ $product->id }}" class="hover:bg-gray-100 transition duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $product->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $product->category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $product->selling_price }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $product->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="{{ $product->status == '1' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} inline-block px-2 py-1 rounded-lg">
                                {{ $product->status == '1' ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('product.edit', $product->id) }}" class="text-blue-500 hover:text-blue-600">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="deleteProduct({{ $product->id }})" class="text-red-500 hover:text-red-600 ml-2">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}

</div>

<script>
    function deleteProduct(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete this product.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/product/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`product-${id}`).remove();
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                            text: data.message
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred. Please try again later.'
                    });
                });
            }
        });
    }
</script>

@endsection
