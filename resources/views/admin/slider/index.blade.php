@extends('layouts.adminlayout')

@section('content')

<div class="my-6">
    <h1 class="text-2xl font-semibold mb-4">Slider</h1>
    <div class="flex justify-between items-center mb-4 space-x-4">
        <form method="GET" action="{{ route('slider.index') }}" class="flex items-center space-x-4 flex-grow">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name" class="form-input w-1/3">
            <select name="status" class="form-select w-1/4">
                <option value="">All</option>
                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md transition duration-200">Filter</button>
        </form>
        <a href="{{ route('slider.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md transition duration-200">Add New Category</a>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($sliders as $slider)
                    <tr id="slider-{{ $slider->id }}" class="hover:bg-gray-100 transition duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="slider-checkbox" value="{{ $slider->id }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $slider->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $slider->title}}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $slider->description}}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($slider->image)
                                <img src="{{ asset('storage/' . $slider->image) }}" alt="Slider Image" class="h-12 w-12 object-cover rounded">
                            @else
                                No Image
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="{{ $slider->status == '1' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} inline-block px-2 py-1 rounded-lg">
                                {{ $slider->status == '1' ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('slider.edit', $slider->id) }}" class="text-blue-500 hover:text-blue-600">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="showCategoryDetails({{ $slider->id }})" class="text-gray-500 hover:text-gray-600 ml-2">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button onclick="deleteCategory({{ $slider->id }})" class="text-red-500 hover:text-red-600 ml-2">
                                <i class="fas fa-trash-alt"></i>
                            </button>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $sliders->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>

<!-- Modal HTML -->
<div id="slider-details-modal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
            <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Category Details</h3>
                <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Close</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="px-4 py-5 sm:px-6">
                <div id="slider-details-content" class="space-y-4">
                    <!-- Dynamic Content Here -->
                </div>
            </div>
        </div>
    </div>
</div>



<script>

document.getElementById('select-all').addEventListener('click', function(event) {
        let checkboxes = document.querySelectorAll('.slider-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = event.target.checked;
        });
    });



    

    function closeModal() {
        document.getElementById('slider-details-modal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }


    function bulkDelete() {
        let selected = [];
        document.querySelectorAll('.slider-checkbox:checked').forEach(checkbox => {
            selected.push(checkbox.value);
        });

        if (selected.length > 0) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete selected sliders.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete them!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/slider/bulk-delete`, {
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
                                document.getElementById(`slider-${id}`).remove();
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
                text: 'Please select at least one slider to delete.'
            });
        }
    }

    function deleteCategory(id) {
        // Customize the confirmation alert
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete this slider.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true // Position buttons as per your requirement
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with deletion
                fetch(`/admin/slider/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the slider row from the UI
                        document.getElementById(`slider-${id}`).remove();
                        // Show a success message using Swal
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                            text: data.message
                        });
                    } else {
                        // Handle error case if needed
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

    function showCategoryDetails(id) {
    fetch(`/admin/slider/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        const modalContent = `
            <div class="flex items-center justify-center mb-4">
                ${data.image ? `<img src="/storage/${data.image}" alt="Category Image" class="h-24 w-24 object-cover rounded-full">` : '<span class="text-gray-500">No Image</span>'}
            </div>
            <div class="text-sm">
                <p><strong>ID:</strong> ${data.id}</p>
                <p><strong>Name:</strong> ${data.name}</p>
                <p><strong>Description:</strong> ${data.description}</p>
                <p><strong>Status:</strong> <span class="${data.status == '1' ? 'text-green-500' : 'text-red-500'}">${data.status == '1' ? 'Active' : 'Inactive'}</span></p>
            </div>
        `;
        document.getElementById('slider-details-content').innerHTML = modalContent;
        document.getElementById('slider-details-modal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    })
    .catch(error => console.error('Error:', error));
}



</script>

@endsection
