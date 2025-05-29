@extends('admin.includes.inc')
@section('content')

<div class="row">
    <div class="col-12 col-lg-12 col-xxl-9 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0" style="font-size: 1.925rem">Offers&nbsp;&nbsp;<span style="color: red;font-size: .925rem"> {{$offers->count()}} {{ $offers->count() === 1 ? 'Result' : 'Results' }} found.</span></h5>
            </div>
            <div class="d-flex justify-content-between align-items-center m-3">
            
                
                <form method="GET" id="filter-form" class="d-flex align-items-center gap-2">
                    <div class="col-auto" style="flex: 1 1 1200px;">
                        <input type="text" name="search" class="form-control" placeholder="Search by offer title"
                            value="{{ request('search') }}" />
                    </div>
                    <select name="status" class="form-select">
                        <option value="">All</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>

                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.offers.index') }}" class="btn btn-secondary">Reset</a>
                    
                </form>
                <div class="d-flex align-items-center gap-2">
                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewOffer"><i class="fa fa-plus m-2" aria-hidden="true"></i>New</a>
                    <button id="bulk-delete" class="btn btn-danger" disabled><i class="fa fa-trash m-2" aria-hidden="true"></i>Delete Selected</button>
                </div>
            </div>
            
            <div id="offer-table-container">
                @include('admin.offer.partials.table', ['offers' => $offers])
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- custom JS -->
<script src="{{ asset('js/admin/offer.ajax.js') }}"></script>

@endsection