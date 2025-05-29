document.addEventListener('DOMContentLoaded', () => {

    // Handle Add Category Form Submission via AJAX
    const addCategoryForm = document.getElementById('add-category-form');
    if (addCategoryForm) {
        addCategoryForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(addCategoryForm);
            
            try {
                const response = await fetch(`/admin/categories`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                console.log(formData);
                if (response.ok) {
                    bootstrap.Modal.getInstance(document.getElementById('addNewCategory')).hide();
                    
                    // alert('Category added successfully.', 'success');
                    showAlert('Category added successfully.', 'success');
                    setTimeout(() => location.reload(), 5000);
                } else {
                    const errorData = await response.json();
                    showAlert('Storing Category failed: ' + (errorData.message || 'Unknown error'), 'danger');
                }
            } catch (error) {
                console.error('Store error:', error);
                showAlert('An error occurred while storing the category.', 'danger');
            }
        });
    }

    // View Category Modal Logic
    document.querySelectorAll('.view-category').forEach(button => {
        button.addEventListener('click', () => {
            const data = {
                id: button.getAttribute('data-id'),
                code: button.getAttribute('data-cat_code'),
                name: button.getAttribute('data-name'),
                description: button.getAttribute('data-description'),
                img: button.getAttribute('data-img'),
                status: button.getAttribute('data-status'),
                created: button.getAttribute('data-created_at'),
                updated: button.getAttribute('data-updated_at'),
                parent_name: button.getAttribute('data-parent_name'),
                display_order: button.getAttribute('data-display_order'),
            };

            const statusText = {
                '0': 'Inactive',
                '1': 'Active',
                '2': 'Deleted'
            }[data.status] || 'Unknown';

            // Populate modal
            document.getElementById('category-cat_code').textContent = data.code;
            document.getElementById('category-name').textContent = data.name;
            document.getElementById('category-description').textContent = data.description;
            document.getElementById('category-logo').src = data.img;
            document.getElementById('category-status').textContent = statusText;
            document.getElementById('category-created-at').textContent = data.created;
            document.getElementById('category-updated-at').textContent = data.updated;
            document.getElementById('category-parent_category').textContent  = data.parent_name || 'No Parent';
            document.getElementById('category-display_order').textContent  = data.display_order;

            bootstrap.Modal.getOrCreateInstance(document.getElementById('categoryDetailsModal')).show();
        });
    });

    // Edit (Open Modal with Category Data)
    document.querySelectorAll('.edit-category').forEach(button => {
        button.addEventListener('click', () => {
            
            const categoryId = button.getAttribute('data-id');
            const cat_code = button.getAttribute('data-cat_code');
            const name = button.getAttribute('data-name');
            const description = button.getAttribute('data-description');
            const img = button.getAttribute('data-img');
            const status = button.getAttribute('data-status');
            const parentId = button.getAttribute('data-parent_id');
            const display_order = button.getAttribute('data-display_order');

            console.log(document.getElementById('edit_image_url'));

            document.getElementById('update-category-id').value = categoryId;
            document.getElementById('edit_category_code').value = cat_code;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_status').value = status;
            document.getElementById('edit_display_order').value = display_order;

            const parentSelect = document.getElementById('edit_parent_id');
            parentSelect.value = parentId && parentId !== 'null' ? parentId : '0';

            const previewImg = document.getElementById('edit_image_preview');
            previewImg.src = img;
            previewImg.style.display = 'block';

            const updateModal = new bootstrap.Modal(document.getElementById('updateCategory'));
            updateModal.show();
        });
    });

    // Update Category via AJAX
    document.getElementById('update-category-form').addEventListener('submit', async (e) => {
        e.preventDefault();

        const categoryId = document.getElementById('update-category-id').value;
        const formData = new FormData();

        formData.append('name', document.getElementById('edit_name').value);
        formData.append('description', document.getElementById('edit_description').value);
        formData.append('status', document.getElementById('edit_status').value);
        formData.append('display_order', document.getElementById('edit_display_order').value);
        
        const parentId = document.getElementById('edit_parent_id').value;
        if (parentId !== "0") {
            formData.append('parent_id', parseInt(parentId)); // valid integer
        }

        // Image only if user selected it
        const imageFile = document.getElementById('edit_image_url').files[0];
        if (imageFile) {
            formData.append('image_url', imageFile);
        }

        formData.append('_method', 'PATCH'); 

        try {
            const response = await fetch(`/admin/categories/${categoryId}`, {
                method: 'POST', // Laravel method spoofing for PATCH
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData
            });

            if (response.ok) {
                const updateModal = bootstrap.Modal.getInstance(document.getElementById('updateCategory'));
                updateModal.hide();

                showAlert('Category updated successfully.');
                location.reload(); // Or re-fetch and update only the row
            } else {
                const errorData = await response.json();
                showAlert('Update failed: ' + (errorData.message || 'Unknown error'));
                console.error('Error Data:', errorData);
            }
        } catch (error) {
            console.error('Update error:', error);
            showAlert('An error occurred while updating the category.');
        }
    });


    // Handle Delete Category
    document.querySelectorAll('.delete-category').forEach(button => {
        button.addEventListener('click', async () => {
            const categoryId = button.getAttribute('data-category-id');
            const confirmed = confirm('Are you sure you want to delete this category?');

            if (!confirmed) return;

            try {
                const response = await fetch(`/admin/categories/${categoryId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    showAlert(result.success || 'Category deleted.', 'success');

                    // Optionally remove row from the table without reload
                    const row = document.getElementById(`category-row-${categoryId}`);
                    if (row) row.remove();
                } else {
                    showAlert(result.error || 'Failed to delete category.', 'danger');
                }
            } catch (error) {
                console.error('Delete error:', error);
                showAlert('An error occurred while deleting the category.', 'danger');
            }
        });
    });

    // Multi-Selection Logic for Bulk Delete
    const selectAllCheckbox = document.getElementById('select-all');
    const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
    const bulkDeleteButton = document.getElementById('bulk-delete');

    // Select/Deselect all checkboxes
    selectAllCheckbox.addEventListener('change', (event) => {
        categoryCheckboxes.forEach(checkbox => {
            checkbox.checked = event.target.checked;
        });
        toggleBulkDeleteButton();
    });

    // Update the "Delete Selected" button based on selected checkboxes
    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', toggleBulkDeleteButton);
    });

    // Function to toggle the "Delete Selected" button
    function toggleBulkDeleteButton() {
        const anyChecked = Array.from(categoryCheckboxes).some(checkbox => checkbox.checked);
        bulkDeleteButton.disabled = !anyChecked;
    }

    // Bulk delete functionality using AJAX
    bulkDeleteButton.addEventListener('click', async () => {
        const selectedCategories = [];
        categoryCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedCategories.push(checkbox.getAttribute('data-category-id'));
            }
        });

        if (selectedCategories.length === 0) return;

        if (confirm('Are you sure you want to delete the selected categories?')) {
            try {
                // Send delete request for each selected user via AJAX
                const response = await fetch('/admin/categories/bulk-delete', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ categoryIds: selectedCategories })
                });

                if (response.ok) {
                    // Remove each deleted row from the DOM
                    selectedCategories.forEach(categoryId => {
                        const row = document.getElementById(`category-row-${categoryId}`);
                        if (row) row.remove();
                    });
                } else {
                    alert('Error deleting selected categories.');
                }
            } catch (error) {
                console.error('Bulk delete error:', error);
                alert('Error deleting selected categories.');
            }
        }
    });

    const filterForm = document.getElementById('filter-form');

    if (filterForm) {
        filterForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(filterForm);
            const query = new URLSearchParams(formData).toString();

            try {
                const response = await fetch(`/admin/categories?${query}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.ok) {
                    const html = await response.text();
                    document.getElementById('category-table-container').innerHTML = html;
                } else {
                    alert('Failed to fetch filtered categories.');
                }
            } catch (err) {
                console.error('AJAX filter error:', err);
            }
        });
    }


    // Auto-dismiss alerts after 4 seconds
    setTimeout(() => {
        ['success-alert', 'error-alert'].forEach(id => {
            const alertEl = document.getElementById(id);
            if (alertEl) {
                alertEl.classList.remove('show');
                alertEl.classList.add('fade');
                setTimeout(() => alertEl.remove(), 500); // optional: remove from DOM after fade
            }
        });
    }, 4000);
});

// Logo Preview for Add Form
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById("image_preview");

    if (input.files?.[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = "block";
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = "";
        preview.style.display = "none";
    }
}

// Logo Preview for Edit Form
function previewEditImage(event) {
    const input = event.target;
    const preview = document.getElementById("edit_image_preview");

    if (input.files?.[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = "block";
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = "";
        preview.style.display = "none";
    }
}

// Optional utility to show a dynamic alert
function showAlert(message, type = 'success') {
    const alertBox = document.createElement('div');
    alertBox.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-4 z-3`;
    alertBox.setAttribute('role', 'alert');
    alertBox.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    document.body.appendChild(alertBox);

    setTimeout(() => {
        alertBox.classList.remove('show');
        alertBox.classList.add('fade');
        setTimeout(() => alertBox.remove(), 500);
    }, 4000);
}
