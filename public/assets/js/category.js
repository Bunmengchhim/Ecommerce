document
    .getElementById("select-all")
    .addEventListener("click", function (event) {
        let checkboxes = document.querySelectorAll(".brand-checkbox");
        checkboxes.forEach((checkbox) => {
            checkbox.checked = event.target.checked;
        });
    });

function closeModal() {
    document.getElementById("brand-details-modal").classList.add("hidden");
    document.body.classList.remove("overflow-hidden");
}

function bulkDelete() {
    let selected = [];
    document.querySelectorAll(".brand-checkbox:checked").forEach((checkbox) => {
        selected.push(checkbox.value);
    });

    if (selected.length > 0) {
        Swal.fire({
            title: "Are you sure?",
            text: "You are about to delete selected categories.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete them!",
            cancelButtonText: "Cancel",
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/brand/bulk-delete`, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({ ids: selected }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            selected.forEach((id) => {
                                document.getElementById(`brand-${id}`).remove();
                            });
                            Swal.fire({
                                icon: "success",
                                title: "Deleted",
                                text: data.message,
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Something went wrong!",
                            });
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "An error occurred. Please try again.",
                        });
                    });
            }
        });
    } else {
        Swal.fire({
            icon: "info",
            title: "No Selection",
            text: "Please select at least one category to delete.",
        });
    }
}

function deleteCategory(id) {
    // Customize the confirmation alert
    Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete this category.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
        reverseButtons: true, // Position buttons as per your requirement
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with deletion
            fetch(`/admin/brand/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        // Remove the category row from the UI
                        document.getElementById(`brand-${id}`).remove();
                        // Show a success message using Swal
                        Swal.fire({
                            icon: "success",
                            title: "Deleted",
                            text: data.message,
                        });
                    } else {
                        // Handle error case if needed
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                        });
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    // Show an error message using Swal
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "An error occurred. Please try again.",
                    });
                });
        }
    });
}

function showCategoryDetails(id) {
    fetch(`/admin/brand/${id}`, {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            const modalContent = `
        <div class="text-sm">
            <p><strong>ID:</strong> ${data.id}</p>
            <p><strong>Name:</strong> ${data.name}</p>
            <p><strong>Slug:</strong> ${data.slug}</p>
            <p><strong>Status:</strong> <span class="${
                data.status == "1" ? "text-green-500" : "text-red-500"
            }">${data.status == "1" ? "Active" : "Inactive"}</span></p>
        </div>
    `;
            document.getElementById("brand-details-content").innerHTML =
                modalContent;
            document
                .getElementById("brand-details-modal")
                .classList.remove("hidden");
            document.body.classList.add("overflow-hidden");
        })
        .catch((error) => console.error("Error:", error));
}
