@extends('layouts.adminlayout')
@section('content')
<div class="my-6">
    <h1 class="text-2xl font-semibold mb-4">Colors</h1>
    <div class="flex justify-between items-center mb-4 space-x-4">
        <form method="GET" action="{{ route('color.index') }}" class="flex items-center space-x-4 flex-grow">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name" class="form-input w-1/3">
            <select name="status" class="form-select w-1/4">
                <option value="">All</option>
                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md transition duration-200">Filter</button>
        </form>
        <button onclick="openCreateBrandModal()" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md transition duration-200">Add New Brand</button>
    </div>
    <div class="mb-4">
        <button onclick="bulkDelete()" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg shadow-md transition duration-200">
            <i class="fas fa-trash-alt"></i> Delete Selected
        </button>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <input type="checkbox" id="select-all">
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($colors as $color)
                    <tr id="color-{{ $color->id }}" class="hover:bg-gray-100 transition duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="color-checkbox" value="{{ $color->id }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $color->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $color->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $color->code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="{{ $color->status == '1' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} inline-block px-2 py-1 rounded-lg">
                                {{ $color->status == '1' ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button onclick="openEditBrandModal({{ $color->id }})" class="text-blue-500 hover:text-blue-600">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="showBrandDetails({{ $color->id }})" class="text-gray-500 hover:text-gray-600 ml-2">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button onclick="deleteBrand({{ $color->id }})" class="text-red-500 hover:text-red-600 ml-2">
                                <i class="fas fa-trash-alt"></i>
                            </button>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $colors->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>
<div id="color-details-modal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
            <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Brand Details</h3>
                <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Close</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="px-4 py-5 sm:px-6">
                <div id="color-details-content" class="space-y-4">
                </div>
            </div>
        </div>
    </div>
</div>


<div id="create-color-modal" class="fixed z-10 inset-0 overflow-y-auto {{ $errors->any() ? '' : 'hidden' }}">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
            <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Create New Brand</h3>
                <button type="button" onclick="closeCreateBrandModal()" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Close</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="px-4 py-5 sm:px-6">
                <!-- Form for creating a new color -->
                <form action="{{ route('color.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
                        <input type="text" name="code" id="code" value="{{ old('code') }}" class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                        @error('code')
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

                    <div class="mt-6">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded inline-block">Create Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="edit-color-modal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
            <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Brand</h3>
                <button type="button" onclick="closeEditBrandModal()" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Close</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="px-4 py-5 sm:px-6">
                <form id="edit-color-form" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit-color-id" name="id">
                    <div class="mb-4">
                        <label for="edit-name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="edit-name" value="{{ old('name') }}" class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="edit-code" class="block text-sm font-medium text-gray-700">Slug</label>
                        <input type="text" name="code" id="edit-code" value="{{ old('code') }}" class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-blue-500">
                        @error('code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <div class="mt-1 flex items-center">
                            <input type="checkbox" name="status" id="edit-status" class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out">
                            <span class="ml-2 text-sm text-gray-700">Active</span>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" onclick="closeEditBrandModal()" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg shadow-md transition duration-200 mr-2">Cancel</button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md transition duration-200">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>

document.getElementById('select-all').addEventListener('click', function(event) {
        let checkboxes = document.querySelectorAll('.color-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = event.target.checked;
        });
    });   
    function closeModal() {
        document.getElementById('color-details-modal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    function bulkDelete() {
        let selected = [];
        document.querySelectorAll('.color-checkbox:checked').forEach(checkbox => {
            selected.push(checkbox.value);
        });

        if (selected.length > 0) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete selected colors.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete them!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/color/bulk-delete`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ ids: selected })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            selected.forEach(id => {
                                document.getElementById(`color-${id}`).remove();
                            });
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
                            text: 'An error occurred. Please try again.'
                        });
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'info',
                title: 'No Selection',
                text: 'Please select at least one color to delete.'
            });
        }
    }
    function deleteBrand(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete this Brand.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true // Position buttons as per your requirement
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/color/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`color-${id}`).remove();
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
                    // Show an error message using Swal
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred. Please try again.'
                    });
                });
            }
        });
    }
    function showBrandDetails(id) {
    fetch(`/admin/color/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        const modalContent = `
            <div class="text-sm">
                <p><strong>ID:</strong> ${data.id}</p>
                <p><strong>Name:</strong> ${data.name}</p>
                <p><strong>Slug:</strong> ${data.code}</p>
                <p><strong>Status:</strong> <span class="${data.status == '1' ? 'text-green-500' : 'text-red-500'}">${data.status == '1' ? 'Active' : 'Inactive'}</span></p>
            </div>
        `;
        document.getElementById('color-details-content').innerHTML = modalContent;
        document.getElementById('color-details-modal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    })
    .catch(error => console.error('Error:', error));
}


function openCreateBrandModal() {
        document.getElementById('create-color-modal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeCreateBrandModal() {
        document.getElementById('create-color-modal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }



    function openEditBrandModal(id) {
    fetch(`/admin/color/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit-color-id').value = data.id;
            document.getElementById('edit-name').value = data.name;
            document.getElementById('edit-code').value = data.code;
            document.getElementById('edit-status').checked = data.status == '1';

            document.getElementById('edit-color-form').action = `/admin/color/${id}`;

            document.getElementById('edit-color-modal').classList.remove('hidden');
        });
}

function closeEditBrandModal() {
    document.getElementById('edit-color-modal').classList.add('hidden');
}
</script>
@endsection
