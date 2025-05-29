$(document).ready(function () {
    $('#add-offer-form').on('submit', function (e) {
        e.preventDefault();

        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        let formData = new FormData(this);

        let submitButton = $('#add-offer-form button[type="submit"]');
        submitButton.prop('disabled', true).html('Saving...');

        $.ajax({
            url: '/admin/offers',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,

            success: function (response) {
                showAlert(response.message);
                $('#addNewOffer').modal('hide');
                $('#add-offer-form')[0].reset();

                // Optionally reload offers list or append new row to table
                // loadOffers(); or update UI accordingly
            },

            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        let field = $(`[name="${key}"]`);
                        field.addClass('is-invalid');
                        field.after(`<div class="invalid-feedback">${value[0]}</div>`);
                    });
                } else {
                    showAlert('Something went wrong. Please try again.');
                }
            }
        });
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById('discount_type');
    const percentageField = document.getElementById('percentage-value');
    const fixedField = document.getElementById('fixed-value');

    function toggleDiscountFields() {
        const value = select.value;

        // Reset all fields
        document.querySelectorAll('.discount-value-field input').forEach(input => {
            input.disabled = true;
            input.closest('.discount-value-field').style.display = 'none';
        });

        if (value === 'percentage') {
            percentageField.style.display = 'block';
            percentageField.querySelector('input').disabled = false;
        } else if (value === 'fixed') {
            fixedField.style.display = 'block';
            fixedField.querySelector('input').disabled = false;
        }
    }


    select.addEventListener('change', toggleDiscountFields);
    toggleDiscountFields();


    // View Offer Modal Logic
    document.querySelectorAll('.view-offer').forEach(button => {
        button.addEventListener('click', () => {
            const data = {
                id: button.getAttribute('data-id'),
                code: button.getAttribute('data-offer_code'),
                title: button.getAttribute('data-title'),
                description: button.getAttribute('data-description'),
                discount_type: button.getAttribute('data-discount_type'),
                discount_value: button.getAttribute('data-discount_value'),
                start_date: button.getAttribute('data-start_date'),
                end_date: button.getAttribute('data-end_date'),
                status: button.getAttribute('data-status'),
                offer_scope: button.getAttribute('data-offer_scope'),
                created_at: button.getAttribute('data-created_at'),
                updated_at: button.getAttribute('data-updated_at'),
            };

            const statusText = {
                '0': 'Inactive',
                '1': 'Active',
                '2': 'Deleted'
            }[data.status] || 'Unknown';

            // Populate modal
            document.getElementById('offer-offer_code').textContent = data.code;
            document.getElementById('offer-title').textContent = data.title;
            document.getElementById('offer-description').textContent = data.description;
            document.getElementById('offer-discount_type').textContent = data.discount_type;
            document.getElementById('offer-discount_value').textContent = data.discount_value || 'Nil';;
            document.getElementById('offer-start_date').textContent = data.start_date;
            document.getElementById('offer-end_date').textContent = data.end_date;
            document.getElementById('offer-offer_scope').textContent  = data.offer_scope;
            document.getElementById('offer-status').textContent  = statusText;
            document.getElementById('offer-created-at').textContent  = data.created_at;
            document.getElementById('offer-updated-at').textContent  = data.updated_at;

            bootstrap.Modal.getOrCreateInstance(document.getElementById('offerDetailsModal')).show();
        });
    });


    // Handle Delete Offer
    document.querySelectorAll('.delete-offer').forEach(button => {
        button.addEventListener('click', async () => {
            const offerId = button.getAttribute('data-offer-id');
            const confirmed = confirm('Are you sure you want to delete this offer?');

            if (!confirmed) return;

            try {
                const response = await fetch(`/admin/offers/${offerId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    showAlert(result.success || 'Offer deleted.', 'success');

                    // Optionally remove row from the table without reload
                    const row = document.getElementById(`offer-row-${offerId}`);
                    if (row) row.remove();
                } else {
                    showAlert(result.error || 'Failed to delete offer.', 'danger');
                }
            } catch (error) {
                console.error('Delete error:', error);
                showAlert('An error occurred while deleting the offer.', 'danger');
            }
        });
    });


    // Multi-Selection Logic for Bulk Delete
    const selectAllCheckbox = document.getElementById('select-all');
    const offerCheckboxes = document.querySelectorAll('.offer-checkbox');
    const bulkDeleteButton = document.getElementById('bulk-delete');

    // Select/Deselect all checkboxes
    selectAllCheckbox.addEventListener('change', (event) => {
        offerCheckboxes.forEach(checkbox => {
            checkbox.checked = event.target.checked;
        });
        toggleBulkDeleteButton();
    });

    // Update the "Delete Selected" button based on selected checkboxes
    offerCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', toggleBulkDeleteButton);
    });

    // Function to toggle the "Delete Selected" button
    function toggleBulkDeleteButton() {
        const anyChecked = Array.from(offerCheckboxes).some(checkbox => checkbox.checked);
        bulkDeleteButton.disabled = !anyChecked;
    }

    // Bulk delete functionality using AJAX
    bulkDeleteButton.addEventListener('click', async () => {
        const selectedOffers = [];
        offerCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedOffers.push(checkbox.getAttribute('data-offer-id'));
            }
        });

        if (selectedOffers.length === 0) return;

        if (confirm('Are you sure you want to delete the selected offers?')) {
            try {
                // Send delete request for each selected user via AJAX
                const response = await fetch('/admin/offers/bulk-delete', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ offerIds: selectedOffers })
                });

                if (response.ok) {
                    // Remove each deleted row from the DOM
                    selectedOffers.forEach(offerId => {
                        const row = document.getElementById(`offer-row-${offerId}`);
                        if (row) row.remove();
                    });
                } else {
                    alert('Error deleting selected offers.');
                }
            } catch (error) {
                console.error('Bulk delete error:', error);
                alert('Error deleting selected offers.');
            }
        }
    });


    // Edit (Open Modal with Offer Data)
    document.querySelectorAll('.edit-offer').forEach(button => {
        button.addEventListener('click', () => {
            
            const offerId = button.getAttribute('data-id');
            const offer_code = button.getAttribute('data-offer_code');
            const title = button.getAttribute('data-title');
            const description = button.getAttribute('data-description');
            const discount_type = button.getAttribute('data-discount_type');
            const discount_value = button.getAttribute('data-discount_value');
            const start_date = button.getAttribute('data-start_date');
            const end_date = button.getAttribute('data-end_date');
            const status = button.getAttribute('data-status');
            const offer_scope = button.getAttribute('data-offer_scope');

            // document.getElementById('update-category-id').value = categoryId;
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_offer_scope').value = offer_scope;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_discount_type').value = discount_type; 
            document.getElementById('edit_start_date').value = start_date;
            document.getElementById('edit_end_date').value = end_date;

            const percentageField = document.getElementById('percentage-value');
            const fixedField = document.getElementById('fixed-value');

            if (discount_type === 'percentage') {
                percentageField.style.display = 'block';
                fixedField.style.display = 'none';
                document.getElementById('edit_discount_value_percentage').value = discount_value;
            } else if (discount_type === 'fixed') {
                percentageField.style.display = 'none';
                fixedField.style.display = 'block';
                document.getElementById('edit_discount_value_fixed').value = discount_value;
            } else {
                // Hide both if discount_type is unknown
                percentageField.style.display = 'none';
                fixedField.style.display = 'none';
            }

            const updateModal = new bootstrap.Modal(document.getElementById('updateOffer'));
            updateModal.show();
        });
    });

    document.getElementById('edit_discount_type').addEventListener('change', function () {
        const type = this.value;
        const percentageField = document.getElementById('edit_percentage-value');
        const fixedField = document.getElementById('edit_fixed-value');

        const percentageInput = document.getElementById('edit_discount_value_percentage');
        const fixedInput = document.getElementById('edit_discount_value_fixed');


        if (type === 'percentage') {
            percentageField.style.display = 'block';
            fixedField.style.display = 'none';
            if (!percentageInput.value && fixedInput.value) {
                percentageInput.value = fixedInput.value;
            }
        } else if (type === 'fixed') {
            percentageField.style.display = 'none';
            fixedField.style.display = 'block';
            if (!fixedInput.value && percentageInput.value) {
                fixedInput.value = percentageInput.value;
            }
        } else {
            percentageField.style.display = 'none';
            fixedField.style.display = 'none';
        }
    });



});


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
