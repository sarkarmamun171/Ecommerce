@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>Add New Role</h3>
    </div>
    <div class="card-body">
        @if (session('role_added'))
            <div class="alert alert-success">{{ session('role_added') }}</div>
        @endif
        <form action="{{ route('update.role', $roles->id)   }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="" class="form-label">Role Name</label>
                <input type="text" name="role_name" class="form-control" value="{{ $roles->name }}">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Permissions</label>

                <div class="form-group">
                    @foreach ($permissions as $permission)
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input {{ $roles->hasPermissionTo($permission->name)?'checked':'' }} type="checkbox" class="form-check-input" name="permission[]" value="{{ $permission->name }}" >{{ $permission->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Update Roles</button>
                </div>

        </form>
    </div>
</div>
@endsection
