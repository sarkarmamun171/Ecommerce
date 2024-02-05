@extends('layouts.admin')
@section('content')
    @can('role_access')
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Role List</h3>
                </div>
                <div class="card-body">
                    @if (session('delete_role'))
                        <div class="alert alert-success">{{ session('delete_role') }}</div>
                    @endif
                    <table class="table table-bordered">
                        <tr>
                            <th>Role</th>
                            <th>Permission</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @foreach ($role->getPermissionNames() as $permission)
                                        <span class="badge badge-primary bg-slate-400 my-1">{{ $permission }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('edit.role', $role->id) }}" class="btn btn-info shadow btn-xs sharp del_btn">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <br><br>
                                    <a href="{{ route('delete.role', $role->id) }}" class="btn btn-danger shadow btn-xs sharp del_btn">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>User List</h3>
                </div>
                <div class="card-body">
                    @if (session('remove_role'))
                        <div class="alert alert-success">{{ session('remove_role') }}</div>
                    @endif
                    <table class="table table-bordered">
                        <tr>
                            <th>User</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>
                                    @forelse ($user->getRoleNames() as $role)
                                        <span class="badge badge-primary bg-slate-400 my-1">{{ $role }}</span>
                                    @empty
                                        Not Assigned
                                    @endforelse
                                </td>
                                <td>
                                    <a href="{{ route('remove.user.role', ['id' => $user->id]) }}" class="btn btn-danger shadow btn-xs sharp del_btn">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add New Permission</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('permission.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="">Permissions</label>
                            <input type="text" name="permission_name" class="form-control">
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Add Permission</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>Add New Role</h3>
                </div>
                <div class="card-body">
                    @if (session('role_added'))
                        <div class="alert alert-success">{{ session('role_added') }}</div>
                    @endif
                    <form action="{{ route('role.store')   }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Role Name</label>
                            <input type="text" name="role_name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Permissions</label>

                            <div class="form-group">
                                @foreach ($permissions as $permission)
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="permission[]" value="{{ $permission->name }}" >{{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Add Roles</button>
                            </div>

                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>Assign Role</h3>
                </div>
                <div class="card-body">
                    @if (session('role_assigned'))
                        <div class="alert alert-success">{{ session('role_assigned') }}</div>
                    @endif
                    <form action="{{ route('role.assign')   }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <select name="user_id" class="form-control">
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <select name="role" class="form-control">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Assign Role</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection
