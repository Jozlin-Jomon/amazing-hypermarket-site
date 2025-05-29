<table class="table table-hover my-0">
    <thead>
        <tr>
            <th>
                <input type="checkbox" id="select-all">
            </th>
            <th>SL NO</th>
            <th class="d-none d-xl-table-cell">Name</th>
            <th class="d-none d-xl-table-cell">Email</th>
            <th class="d-none d-xl-table-cell">Phone</th>
            <th class="d-none d-xl-table-cell">Created Date</th>
            <th class="d-none d-xl-table-cell">Status</th>
            <th class="d-none d-xl-table-cell">Update Status</th>
            <th class="d-none d-xl-table-cell">Action</th>

        </tr>
    </thead>
    <tbody>
        @foreach($users as $u =>$user)
        <tr id="user-row-{{ $user->id }}">
            <td>
                <input type="checkbox" class="user-checkbox" data-user-id="{{ $user->id }}">
            </td>
            <td>{{$u+1}}</td>
            <td>{{$user->first_name}} {{$user->last_name}}</td>
            <td class="d-none d-xl-table-cell">{{$user->email}}</td>
            <td class="d-none d-xl-table-cell">{{$user->phone}}</td>
            <td class="d-none d-xl-table-cell">{{$user->created_at}}</td>
            <td>
                @if($user->status == 1)
                    <span class="badge bg-success">ACTIVE</span>
                @else
                    <span class="badge bg-warning">INACTIVE</span>
                @endif
            </td>
            <td class="d-none d-md-table-cell">
                <form action="{{ route('admin.users.update-status', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input type="hidden" name="status" value="0">
                    <label class="switch">
                        <input type="checkbox" name="status" value="1" {{ $user->status == 1 ? 'checked' : '' }} onchange="this.form.submit()"></input>
                        <span class="slider"></span>
                    </label>
                </form>
            </td>
            <td>
                <a class="button touch edit edit-user"
                data-id="{{ $user->id }}" 
                data-first_name="{{ $user->first_name }}"
                data-last_name="{{ $user->last_name }}"
                data-email="{{ $user->email }}"
                data-phone="{{ $user->phone }}"></a>

                <a class="button touch delete delete-user"
                data-user-id= "{{ $user->id }}"
                title="Delete User"></a>
                <form id="deleteForm{{ $user->id }}" action="{{ route('admin.users.destroy', ['userId' => $user->id]) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
                
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-3">
    {{ $users->appends(request()->query())->links() }}
</div>

<!-- Update User Modal -->
<div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="update-user-form">
            @csrf
            @method('PATCH')
            <input type="hidden" name="user_id" id="update-user-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateUserModalLabel">Update User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update User</button>
                </div>
            </div>
        </form>
    </div>
</div>
