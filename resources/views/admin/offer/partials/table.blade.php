@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-4 z-3" role="alert" id="success-alert">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-4 z-3" role="alert" id="error-alert">
        {{ session('error') }}
    </div>
@endif

<table class="table table-hover my-0">
    <thead>
        <tr>
            <th>
                <input type="checkbox" id="select-all">
            </th>
            <th>SL NO</th>
            <th class="d-none d-xl-table-cell">Code</th>
            <th class="d-none d-xl-table-cell">Title</th>
            <th class="d-none d-xl-table-cell">Status</th>
            <th class="d-none d-xl-table-cell">Created Date</th>
            <th class="d-none d-xl-table-cell">Update Status</th>
            <th class="d-none d-xl-table-cell">Action</th>

        </tr>
    </thead>
    <tbody>
        @foreach($offers as $o =>$offer)
        <tr id="offer-row-{{ $offer->offer_id }}">
            <td>
                <input type="checkbox" class="offer-checkbox" data-offer-id="{{ $offer->offer_id }}">
            </td>
            <td>{{$o+1}}</td>
            <td>{{$offer->offer_code}}</td>
            <td>{{$offer->title}}</td>
            <td>
                @if($offer->status == 1)
                    <span class="badge bg-success">ACTIVE</span>
                @elseif($offer->status == 0)
                    <span class="badge bg-warning">INACTIVE</span>
                @else
                    <span class="badge bg-danger">DELETED</span>
                @endif
            </td>
            <td class="d-none d-xl-table-cell">{{$offer->created_at}}</td>
            <td class="d-none d-md-table-cell">
                <form action="{{ route('admin.offers.update-status', $offer->offer_id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="offer_id" value="{{ $offer->offer_id }}">
                    <input type="hidden" name="status" value="0">
                    <label class="switch">
                        <input type="checkbox" name="status" value="1" {{ $offer->status == 1 ? 'checked' : '' }} onchange="this.form.submit()"></input>
                        <span class="slider"></span>
                    </label>
                </form>
            </td>
            <td>
                <a class="btn btn-outline-success view-offer"
                data-id="{{ $offer->offer_id }}" 
                data-offer_code="{{ $offer->offer_code }}"
                data-title="{{ $offer->title }}"
                data-description="{{ $offer->description }}"
                data-discount_type="{{ $offer->discount_type }}"
                data-discount_value="{{ $offer->discount_value ? $offer->discount_value : '--' }}"
                data-start_date="{{ $offer->start_date }}"
                data-end_date="{{ $offer->end_date }}"
                data-status="{{ $offer->status }}"
                data-offer_scope="{{ $offer->offer_scope }}"
                data-created_at="{{ $offer->created_at }}"
                data-updated_at="{{ $offer->updated_at }}"><i class="fa fa-eye m-2" aria-hidden="true"></i></a>

                <a class="btn btn-outline-primary edit-offer"
                data-id="{{ $offer->offer_id }}" 
                data-offer_code="{{ $offer->offer_code }}"
                data-title="{{ $offer->title }}"
                data-description="{{ $offer->description }}"
                data-discount_type="{{ $offer->discount_type }}"
                data-discount_value="{{ $offer->discount_value }}"
                data-start_date="{{ \Carbon\Carbon::parse($offer->start_date)->format('Y-m-d') }}"
                data-end_date="{{ \Carbon\Carbon::parse($offer->end_date)->format('Y-m-d') }}"
                data-status="{{ $offer->status }}"
                data-offer_scope="{{ $offer->offer_scope }}"
                data-created_at="{{ $offer->created_at }}"
                data-updated_at="{{ $offer->updated_at }}"><i class="fa fa-edit m-2" aria-hidden="true"></i>
                </a>

                <a class="btn btn-outline-danger delete-offer"
                data-offer-id= "{{ $offer->offer_id }}"
                title="Delete Offer"><i class="fa fa-trash m-2" aria-hidden="true"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-0">
    {{ $offers->appends(request()->query())->links() }}
</div>

<!-- Add Offer Modal -->
<div class="modal fade" id="addNewOffer" tabindex="-1" aria-labelledby="addOfferModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="add-offer-form" enctype="multipart/form-data" class="w-100">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addOfferModalLabel">Add New Offer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label">Offer Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="col-md-6">
                                <label for="offer_scope" class="form-label">Offer Applies To</label>
                                <select name="offer_scope" id="offer_scope" class="form-control" required>
                                    @foreach (config('enums.offer_scopes') as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="discount_type" class="form-label">Discount Type</label>
                                <select name="discount_type" id="discount_type" class="form-control" required>
                                    @foreach (config('enums.discount_types') as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div id="percentage-value" class="discount-value-field" style="display: none;">
                                    <label for="discount_value">Discount (%)</label>
                                    <input type="number" name="discount_value" class="form-control" min="1" max="100" step="1">
                                </div>
                                <div id="fixed-value" class="discount-value-field" style="display: none;">
                                    <label for="discount_value">Discount Amount</label>
                                    <input type="number" name="discount_value" class="form-control" step="0.01" min="0">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Offer Details Modal -->
<div class="modal fade" id="offerDetailsModal" tabindex="-1" aria-labelledby="offerDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg rounded-4 border-0">
            <!-- Modal Header -->
            <div class="modal-header bg-dark text-white rounded-top-4">
                <h5 class="modal-title" id="offerDetailsModalLabel">
                    <i class="bi bi-info-circle me-2"></i>Offer Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Details Table -->
                    <div class="col-12">
                        <table class="table table-borderless">
                            <tbody class="text-secondary">
                                <tr>
                                    <th class="text-uppercase small text-muted">Offer Code:</th>
                                    <td id="offer-offer_code" class="fw-semibold text-dark"></td>
                                </tr>
                                <tr>
                                    <th class="text-uppercase small text-muted">Title:</th>
                                    <td id="offer-title" class="fw-semibold text-dark"></td>
                                </tr>
                                <tr>
                                    <th class="text-uppercase small text-muted">Description:</th>
                                    <td id="offer-description" class="text-dark"></td>
                                </tr>
                                <tr>
                                    <th class="text-uppercase small text-muted">Discount Type:</th>
                                    <td id="offer-discount_type" class="text-dark"></td>
                                </tr>
                                <tr>
                                    <th class="text-uppercase small text-muted">Discount Value:</th>
                                    <td id="offer-discount_value" class="text-dark"></td>
                                </tr>
                                <tr>
                                    <th class="text-uppercase small text-muted">Start Date:</th>
                                    <td id="offer-start_date" class="text-dark"></td>
                                </tr>
                                <tr>
                                    <th class="text-uppercase small text-muted">End Date:</th>
                                    <td id="offer-end_date" class="text-dark"></td>
                                </tr>
                                <tr>
                                    <th class="text-uppercase small text-muted">Offer Scope:</th>
                                    <td id="offer-offer_scope" class="text-dark"></td>
                                </tr>
                                <tr>
                                    <th class="text-uppercase small text-muted">Status:</th>
                                    <td id="offer-status"></td>
                                </tr>
                                <tr>
                                    <th class="text-uppercase small text-muted">Created At:</th>
                                    <td id="offer-created-at" class="text-dark"></td>
                                </tr>
                                <tr>
                                    <th class="text-uppercase small text-muted">Updated At:</th>
                                    <td id="offer-updated-at" class="text-dark"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer border-top-0 rounded-bottom-4">
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">
                    <i class="bi bi-arrow-left me-1"></i>Back
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Update Offer Modal -->
<div class="modal fade " id="updateOffer" tabindex="-1" aria-labelledby="updateOfferModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="update-offer-form">
            @csrf
            @method('PATCH')
            <input type="hidden" name="offer_id" id="update-offer-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateOfferModalLabel">Update Offer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label">Offer Title</label>
                                <input type="text" class="form-control" id="edit_title" name="title" required>
                            </div>
                            <div class="col-md-6">
                                <label for="offer_scope" class="form-label">Offer Applies To</label>
                                <select name="offer_scope" id="edit_offer_scope" class="form-control" required>
                                    @foreach (config('enums.offer_scopes') as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="discount_type" class="form-label">Discount Type</label>
                                <select name="discount_type" id="edit_discount_type" class="form-control" required>
                                    @foreach (config('enums.discount_types') as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div id="edit_percentage-value" class="discount-value-field" style="display: none;">
                                    <label for="discount_value">Discount (%)</label>
                                    <input type="number" id="edit_discount_value_percentage" name="discount_value" class="form-control" min="1" max="100" step="1">
                                </div>
                                <div id="edit_fixed-value" class="discount-value-field" style="display: none;">
                                    <label for="discount_value">Discount Amount</label>
                                    <input type="number" id="edit_discount_value_fixed" name="discount_value" class="form-control" step="0.01" min="0">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="edit_end_date" name="end_date" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update Category</button>
                </div>
            </div>
        </form>
    </div>
</div>







