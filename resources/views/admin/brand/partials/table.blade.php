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
            <th class="d-none d-xl-table-cell">Name</th>
            <th class="d-none d-xl-table-cell">Status</th>
            <th class="d-none d-xl-table-cell">Created Date</th>
            <th class="d-none d-xl-table-cell">Update Status</th>
            <th class="d-none d-xl-table-cell">Action</th>

        </tr>
    </thead>
    <tbody>
        @foreach($brands as $b =>$brand)
        <tr id="brand-row-{{ $brand->brand_id }}">
            <td>
                <input type="checkbox" class="brand-checkbox" data-brand-id="{{ $brand->brand_id }}">
            </td>
            <td>{{$b+1}}</td>
            <td>{{$brand->name}}</td>
            <td>
                @if($brand->status == 1)
                    <span class="badge bg-success">ACTIVE</span>
                @elseif($brand->status == 0)
                    <span class="badge bg-warning">INACTIVE</span>
                @else
                    <span class="badge bg-danger">DELETED</span>
                @endif
            </td>
            <td class="d-none d-xl-table-cell">{{$brand->created_at}}</td>
            <td class="d-none d-md-table-cell">
                <form action="{{ route('admin.brands.update-status', $brand) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="brand_id" value="{{ $brand->brand_id }}">
                    <input type="hidden" name="status" value="0">
                    <label class="switch">
                        <input type="checkbox" name="status" value="1" {{ $brand->status == 1 ? 'checked' : '' }} onchange="this.form.submit()"></input>
                        <span class="slider"></span>
                    </label>
                </form>
            </td>
            <td>
                <a class="btn btn-outline-success view-brand"
                data-id="{{ $brand->brand_id }}" 
                data-brand_code="{{ $brand->brand_code }}"
                data-name="{{ $brand->name }}"
                data-description="{{ $brand->description }}"
                data-logo="{{ asset($brand->logo_url) }}"
                data-status="{{ $brand->status }}"
                data-created_at="{{ $brand->created_at }}"
                data-updated_at="{{ $brand->updated_at }}"><i class="fa fa-eye m-2" aria-hidden="true"></i></a>

                <a class="btn btn-outline-primary edit-brand"
                data-id="{{ $brand->brand_id }}" 
                data-brand_code="{{ $brand->brand_code }}"
                data-name="{{ $brand->name }}"
                data-description="{{ $brand->description }}"
                data-logo="{{ asset($brand->logo_url) }}"
                data-status="{{ $brand->status }}"><i class="fa fa-edit m-2" aria-hidden="true"></i>
                </a>
                
                <a class="btn btn-outline-danger delete-brand"
                data-brand-id= "{{ $brand->brand_id }}"
                title="Delete Brand"><i class="fa fa-trash m-2" aria-hidden="true"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-0">
    {{ $brands->appends(request()->query())->links() }}
</div>

<!-- Add Brand Modal -->
<div class="modal fade" id="addNewBrand" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="add-brand-form" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBrandModalLabel">Add New Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Brand Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="logo_url" class="form-label">Logo</label>
                        <input type="file" class="form-control" id="logo_url" name="logo_url" accept="image/*" onchange="previewImage(event)" required>
                    </div>
                    <div class="mb-3 text-center">
                        <img id="image_preview" src="" alt="Image Preview" class="img-fluid" style="max-width: 100%; display: none;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Update Brand Modal -->
<div class="modal fade" id="updateBrand" tabindex="-1" aria-labelledby="updateBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="update-brand-form">
            @csrf
            @method('PATCH')
            <input type="hidden" name="brand_id" id="update-brand-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateBrandModalLabel">Update Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="brand_code" class="form-label">Brand Code</label>
                        <input type="text" class="form-control" id="edit_brand_code" name="brand_code" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Brand Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="logo_url" class="form-label">Logo</label>
                        <input type="file" class="form-control" id="edit_logo_url" name="logo_url" accept="image/*" onchange="previewEditImage(event)">
                    </div>
                    <div class="mb-3 text-center">
                        <img id="edit_image_preview" src="" alt="Image Preview" class="img-fluid" style="max-width: 100%; display: none;">
                    </div>
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select class="form-select" id="edit_status" name="status" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update Brand</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Brand Details Modal -->
<div class="modal fade" id="brandDetailsModal" tabindex="-1" aria-labelledby="brandDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg rounded-4">
            <!-- Modal Header -->
            <div class="modal-header bg-secondary text-white border-bottom-0">
                <h5 class="modal-title" id="brandDetailsModalLabel">Brand Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <!-- Brand Details -->
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <th class="fw-bold">BRAND CODE:</th>
                                <td id="brand-brand_code"></td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Name:</th>
                                <td id="brand-name"></td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Description:</th>
                                <td id="brand-description"></td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Status:</th>
                                <td id="brand-status" class="fw-bold"></td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Created At:</th>
                                <td id="brand-created-at"></td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Updated At:</th>
                                <td id="brand-updated-at"></td>
                            </tr>
                        </table>
                    </div>
                    
                    <!-- Logo Column -->
                    <div class="col-md-4 text-center">
                        <img id="brand-logo" src="" alt="Brand Logo" class="img-fluid rounded-3 shadow-lg" style="object-fit: contain; max-height: 250px; border: 4px solid #fff; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);">
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-arrow-left"></i> Back
                </button>
            </div>
        </div>
    </div>
</div>



