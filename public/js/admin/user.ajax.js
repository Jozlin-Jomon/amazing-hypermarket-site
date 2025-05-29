document.addEventListener('DOMContentLoaded', () => {
    
    // Edit (Open Modal with User Data)
    document.querySelectorAll('.edit-user').forEach(button => {
        button.addEventListener('click', () => {
            const userId = button.getAttribute('data-id');
            const firstName = button.getAttribute('data-first_name');
            const lastName = button.getAttribute('data-last_name');
            const email = button.getAttribute('data-email');
            const phone = button.getAttribute('data-phone');

            document.getElementById('update-user-id').value = userId;
            document.getElementById('first_name').value = firstName;
            document.getElementById('last_name').value = lastName;
            document.getElementById('email').value = email;
            document.getElementById('phone').value = phone;

            const updateModal = new bootstrap.Modal(document.getElementById('updateUserModal'));
            updateModal.show();
        });
    });

    // Update User via AJAX
    document.getElementById('update-user-form').addEventListener('submit', async (e) => {
        e.preventDefault();

        const userId = document.getElementById('update-user-id').value;
        const form = e.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        try {
            const response = await fetch(`/admin/users/${userId}`, {
                method: 'POST', // Laravel method spoofing for PATCH
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            if (response.ok) {
                const updateModal = bootstrap.Modal.getInstance(document.getElementById('updateUserModal'));
                updateModal.hide();

                alert('User updated successfully.');
                location.reload(); // Or re-fetch and update only the row
            } else {
                const errorData = await response.json();
                alert('Update failed: ' + (errorData.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Update error:', error);
            alert('An error occurred while updating the user.');
        }
    });


    // Individual Delete (AJAX)
    const deleteButtons = document.querySelectorAll('.delete-user');
    deleteButtons.forEach(button => {
        button.addEventListener('click', async (event) => {
            event.preventDefault();
            const userId = button.getAttribute('data-user-id');
    
            if (confirm('Are you sure you want to delete this item?')) {
                try {
                    const response = await fetch(`/admin/users/${userId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        },
                    });
    
                    if (response.ok) {
                        // Remove the row or refresh part of the UI
                        document.getElementById(`user-row-${userId}`).remove();
                    } else {
                        alert('Error deleting user.');
                    }
                } catch (error) {
                    console.error('Delete error:', error);
                    alert('Error deleting user.');
                }
            }
        });
    });

    // Multi-Selection Logic for Bulk Delete
    const selectAllCheckbox = document.getElementById('select-all');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    const bulkDeleteButton = document.getElementById('bulk-delete');

    // Select/Deselect all checkboxes
    selectAllCheckbox.addEventListener('change', (event) => {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = event.target.checked;
        });
        toggleBulkDeleteButton();
    });

    // Update the "Delete Selected" button based on selected checkboxes
    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', toggleBulkDeleteButton);
    });

    // Function to toggle the "Delete Selected" button
    function toggleBulkDeleteButton() {
        const anyChecked = Array.from(userCheckboxes).some(checkbox => checkbox.checked);
        bulkDeleteButton.disabled = !anyChecked;
    }

    // Bulk delete functionality using AJAX
    bulkDeleteButton.addEventListener('click', async () => {
        const selectedUsers = [];
        userCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedUsers.push(checkbox.getAttribute('data-user-id'));
            }
        });

        if (selectedUsers.length === 0) return;

        if (confirm('Are you sure you want to delete the selected users?')) {
            try {
                // Send delete request for each selected user via AJAX
                const response = await fetch('/admin/users/bulk-delete', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ userIds: selectedUsers })
                });

                if (response.ok) {
                    // Remove each deleted row from the DOM
                    selectedUsers.forEach(userId => {
                        const row = document.getElementById(`user-row-${userId}`);
                        if (row) row.remove();
                    });
                } else {
                    alert('Error deleting selected users.');
                }
            } catch (error) {
                console.error('Bulk delete error:', error);
                alert('Error deleting selected users.');
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
                const response = await fetch(`/admin/users?${query}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.ok) {
                    const html = await response.text();
                    document.getElementById('user-table-container').innerHTML = html;
                } else {
                    alert('Failed to fetch filtered users.');
                }
            } catch (err) {
                console.error('AJAX filter error:', err);
            }
        });
    }

});


