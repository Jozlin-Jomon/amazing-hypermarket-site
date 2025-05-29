@extends('admin.includes.inc')
@section('content')

<div class="row">
    <div class="col-12 col-lg-12 col-xxl-9 d-flex">
        <div class="card flex-fill">
            @if (session('success'))
                <div class="my-alert my-alert-success">
                    {{ session('success') }}
                    <span class="my-alert-close" onclick="this.parentElement.style.display='none';">&times;</span>
                </div>
            @endif

            @if (session('error'))
                <div class="my-alert my-alert-error">
                    {{ session('error') }}
                    <span class="my-alert-close" onclick="this.parentElement.style.display='none';">&times;</span>
                </div>
            @endif

            <div class="card-header mb-2">
                <h5 class="card-title mb-0" style="font-size: 1.925rem">Users List&nbsp;&nbsp;<span style="color: red;font-size: .925rem"> {{$users->count()}} {{ $users->count() === 1 ? 'Result' : 'Results' }} found.</span></h5>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
            
                
                <form method="GET" id="filter-form" class="d-flex align-items-center gap-2">
                    <div class="col-auto" style="flex: 1 1 1500px;">
                        <input type="text" name="search" class="form-control" placeholder="Search by name or email"
                            value="{{ request('search') }}" />
                    </div>
                    <select name="status" class="form-select">
                        <option value="">All</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>

                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Reset</a>
                </form>

                <!-- <a class="button primary new" data-bs-toggle="modal" data-bs-target="#addNewUser">New</a> -->
                <button id="bulk-delete" class="button primary delete" disabled>Delete Selected</button>
            </div>
            
            <div id="user-table-container">
                @include('admin.user.partials.table', ['users' => $users])
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- custom JS -->
<script src="{{ asset('js/admin/user.ajax.js') }}"></script>

@endsection