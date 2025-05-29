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
        @foreach($categories as $c =>$category)
        <tr id="category-row-{{ $category->category_id }}">
            <td>
                <input type="checkbox" class="category-checkbox" data-category-id="{{ $category->category_id }}">
            </td>
            <td>{{$c+1}}</td>
            <td>{{$category->name}}</td>
            <td>
                @if($category->status == 1)
                    <span class="badge bg-success">ACTIVE</span>
                @elseif($category->status == 0)
                    <span class="badge bg-warning">INACTIVE</span>
                @else
                    <span class="badge bg-danger">DELETED</span>
                @endif
            </td>
            <td class="d-none d-xl-table-cell">{{$category->created_at}}</td>
            <td class="d-none d-md-table-cell">
                <form action="{{ route('admin.categories.update-status', $category) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="category_id" value="{{ $category->category_id }}">
                    <input type="hidden" name="status" value="0">
                    <label class="switch">
                        <input type="checkbox" name="status" value="1" {{ $category->status == 1 ? 'checked' : '' }} onchange="this.form.submit()"></input>
                        <span class="slider"></span>
                    </label>
                </form>
            </td>
            <td>
                <a class="btn btn-outline-success view-category"
                data-id="{{ $category->category_id }}" 
                data-cat_code="{{ $category->cat_code }}"
                data-name="{{ $category->name }}"
                data-description="{{ $category->description }}"
                data-parent_name="{{ $category->parent_id ? optional($category->parent)->name : 'No Parent' }}"
                data-display_order="{{ $category->display_order}}"
                data-img="{{ asset($category->image_url) }}"
                data-status="{{ $category->status }}"
                data-created_at="{{ $category->created_at }}"
                data-updated_at="{{ $category->updated_at }}"><i class="fa fa-eye m-2" aria-hidden="true"></i></a>

                <a class="btn btn-outline-primary edit-category"
                data-id="{{ $category->category_id }}" 
                data-cat_code="{{ $category->cat_code }}"
                data-name="{{ $category->name }}"
                data-description="{{ $category->description }}"
                data-parent_id="{{ $category->parent_id }}"
                data-display_order="{{ $category->display_order}}"
                data-img="{{ asset($category->image_url) }}"
                data-status="{{ $category->status }}"><i class="fa fa-edit m-2" aria-hidden="true"></i>
                </a>
                
                <a class="btn btn-outline-danger delete-category"
                data-category-id= "{{ $category->category_id }}"
                title="Delete Category"><i class="fa fa-trash m-2" aria-hidden="true"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-0">
    {{ $categories->appends(request()->query())->links() }}
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addNewCategory" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="add-category-form" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="parent_id" class="form-label">Parent Category</label>
                        <select class="form-select" id="parent_id" name="parent_id">
                            <option value="0">No Parent</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->category_id }}">{{ $parent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image_url" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image_url" name="image_url" accept="image/*" onchange="previewImage(event)" required>
                    </div>
                    <div class="mb-3 text-center">
                        <img id="image_preview" src="" alt="Image Preview" class="img-fluid" style="max-width: 100%; display: none;">
                    </div>
                    <div class="mb-3">
                        <label for="display_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="display_order" name="display_order" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Update Category Modal -->
<div class="modal fade " id="updateCategory" tabindex="-1" aria-labelledby="updateCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="update-category-form">
            @csrf
            @method('PATCH')
            <input type="hidden" name="category_id" id="update-category-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateCategoryModalLabel">Update Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="category_code" class="form-label">Category Code</label>
                        <input type="text" class="form-control" id="edit_category_code" name="category_code" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_parent_id" class="form-label">Parent Category</label>
                        <select class="form-select" id="edit_parent_id" name="parent_id" required>
                            <option value="0">No Parent (Top level Category)</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->category_id }}">{{ $parent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image_url" class="form-label">Image</label>
                        <input type="file" class="form-control" id="edit_image_url" name="image_url" accept="image/*" onchange="previewEditImage(event)">
                    </div>
                    <div class="mb-3 text-center">
                        <img id="edit_image_preview" src="" alt="Image Preview" class="img-fluid" style="max-width: 100%; display: none;">
                    </div>
                    <div class="mb-3">
                        <label for="display_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="edit_display_order" name="display_order" required>
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
                    <button type="submit" class="btn btn-success">Update Category</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Category Details Modal -->
<div class="modal fade" id="categoryDetailsModal" tabindex="-1" aria-labelledby="categoryDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg rounded-4">
            <!-- Modal Header -->
            <div class="modal-header bg-secondary text-white border-bottom-0">
                <h5 class="modal-title" id="categoryDetailsModalLabel">Category Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <!-- Category Details Column -->
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <th class="fw-bold">BRAND CODE:</th>
                                <td id="category-cat_code"></td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Name:</th>
                                <td id="category-name"></td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Description:</th>
                                <td id="category-description"></td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Parent Category:</th>
                                <td id="category-parent_category"></td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Display Order:</th>
                                <td id="category-display_order"></td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Status:</th>
                                <td id="category-status" class="fw-bold"></td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Created At:</th>
                                <td id="category-created-at"></td>
                            </tr>
                            <tr>
                                <th class="fw-bold">Updated At:</th>
                                <td id="category-updated-at"></td>
                            </tr>
                        </table>
                    </div>
                    
                    <!-- Logo Column -->
                    <div class="col-md-4 text-center">
                        <img id="category-logo" src="" alt="Category Logo" class="img-fluid rounded-3 shadow-lg" style="object-fit: contain; max-height: 250px; border: 4px solid #fff; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);">
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



