document.addEventListener('DOMContentLoaded', () => {

    // Handle Add Brand Form Submission via AJAX
    const addBrandForm = document.getElementById('add-brand-form');
    if (addBrandForm) {
        addBrandForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(addBrandForm);

            try {
                const response = await fetch(`/admin/brands`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (response.ok) {
                    bootstrap.Modal.getInstance(document.getElementById('addNewBrand')).hide();
                    
                    // Use Bootstrap alert instead of alert box
                    showAlert('Brand added successfully.', 'success');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    const errorData = await response.json();
                    showAlert('Storing brand failed: ' + (errorData.message || 'Unknown error'), 'danger');
                }
            } catch (error) {
                console.error('Store error:', error);
                showAlert('An error occurred while storing the brand.', 'danger');
            }
        });
    }

    // View Brand Modal Logic
    document.querySelectorAll('.view-brand').forEach(button => {
        button.addEventListener('click', () => {
            const data = {
                id: button.getAttribute('data-id'),
                code: button.getAttribute('data-brand_code'),
                name: button.getAttribute('data-name'),
                description: button.getAttribute('data-description'),
                logo: button.getAttribute('data-logo'),
                status: button.getAttribute('data-status'),
                created: button.getAttribute('data-created_at'),
                updated: button.getAttribute('data-updated_at'),
            };

            const statusText = {
                '0': 'Inactive',
                '1': 'Active',
                '2': 'Deleted'
            }[data.status] || 'Unknown';

            // Populate modal
            document.getElementById('brand-brand_code').textContent = data.code;
            document.getElementById('brand-name').textContent = data.name;
            document.getElementById('brand-description').textContent = data.description;
            document.getElementById('brand-logo').src = data.logo;
            document.getElementById('brand-status').textContent = statusText;
            document.getElementById('brand-created-at').textContent = data.created;
            document.getElementById('brand-updated-at').textContent = data.updated;

            bootstrap.Modal.getOrCreateInstance(document.getElementById('brandDetailsModal')).show();
        });
    });

    // Edit (Open Modal with Brand Data)
    document.querySelectorAll('.edit-brand').forEach(button => {
        button.addEventListener('click', () => {
            
            const brandId = button.getAttribute('data-id');
            const brand_code = button.getAttribute('data-brand_code');
            const name = button.getAttribute('data-name');
            const description = button.getAttribute('data-description');
            const logo = button.getAttribute('data-logo');
            const status = button.getAttribute('data-status');

            console.log(document.getElementById('edit_logo_url'));

            document.getElementById('update-brand-id').value = brandId;
            document.getElementById('edit_brand_code').value = brand_code;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_description').value = description;
            // document.getElementById('edit_logo_url').src = logo;
            document.getElementById('edit_status').value = status;

            const previewImg = document.getElementById('edit_image_preview');
            previewImg.src = logo;
            previewImg.style.display = 'block';

            const updateModal = new bootstrap.Modal(document.getElementById('updateBrand'));
            updateModal.show();
        });
    });

    // Update Brand via AJAX
    document.getElementById('update-brand-form').addEventListener('submit', async (e) => {
        e.preventDefault();

        const brandId = document.getElementById('update-brand-id').value;
        const form = e.target;
        const formData = new FormData(form);

        try {
            const response = await fetch(`/admin/brands/${brandId}`, {
                method: 'POST', // Laravel method spoofing for PATCH
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData
            });

            if (response.ok) {
                const updateModal = bootstrap.Modal.getInstance(document.getElementById('updateBrand'));
                updateModal.hide();

                showAlert('Brand updated successfully.');
                location.reload(); // Or re-fetch and update only the row
            } else {
                const errorData = await response.json();
                showAlert('Update failed: ' + (errorData.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Update error:', error);
            showAlert('An error occurred while updating the brand.');
        }
    });


    // Handle Delete Brand
    document.querySelectorAll('.delete-brand').forEach(button => {
        button.addEventListener('click', async () => {
            const brandId = button.getAttribute('data-brand-id');
            const confirmed = confirm('Are you sure you want to delete this brand?');

            if (!confirmed) return;

            try {
                const response = await fetch(`/admin/brands/${brandId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    showAlert(result.success || 'Brand deleted.', 'success');

                    // Optionally remove row from the table without reload
                    const row = document.getElementById(`brand-row-${brandId}`);
                    if (row) row.remove();
                } else {
                    showAlert(result.error || 'Failed to delete brand.', 'danger');
                }
            } catch (error) {
                console.error('Delete error:', error);
                showAlert('An error occurred while deleting the brand.', 'danger');
            }
        });
    });

    // Multi-Selection Logic for Bulk Delete
    const selectAllCheckbox = document.getElementById('select-all');
    const brandCheckboxes = document.querySelectorAll('.brand-checkbox');
    const bulkDeleteButton = document.getElementById('bulk-delete');

    // Select/Deselect all checkboxes
    selectAllCheckbox.addEventListener('change', (event) => {
        brandCheckboxes.forEach(checkbox => {
            checkbox.checked = event.target.checked;
        });
        toggleBulkDeleteButton();
    });

    // Update the "Delete Selected" button based on selected checkboxes
    brandCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', toggleBulkDeleteButton);
    });

    // Function to toggle the "Delete Selected" button
    function toggleBulkDeleteButton() {
        const anyChecked = Array.from(brandCheckboxes).some(checkbox => checkbox.checked);
        bulkDeleteButton.disabled = !anyChecked;
    }

    // Bulk delete functionality using AJAX
    bulkDeleteButton.addEventListener('click', async () => {
        const selectedBrands = [];
        brandCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedBrands.push(checkbox.getAttribute('data-brand-id'));
            }
        });

        if (selectedBrands.length === 0) return;

        if (confirm('Are you sure you want to delete the selected brands?')) {
            try {
                // Send delete request for each selected user via AJAX
                const response = await fetch('/admin/brands/bulk-delete', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ brandIds: selectedBrands })
                });

                if (response.ok) {
                    // Remove each deleted row from the DOM
                    selectedBrands.forEach(brandId => {
                        const row = document.getElementById(`brand-row-${brandId}`);
                        if (row) row.remove();
                    });
                } else {
                    alert('Error deleting selected brands.');
                }
            } catch (error) {
                console.error('Bulk delete error:', error);
                alert('Error deleting selected brands.');
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
                const response = await fetch(`/admin/brands?${query}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.ok) {
                    const html = await response.text();
                    document.getElementById('brand-table-container').innerHTML = html;
                } else {
                    alert('Failed to fetch filtered brands.');
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
