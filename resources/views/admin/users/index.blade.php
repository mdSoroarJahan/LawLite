@extends('layouts.app')

@section('content')
    <div class="container py-6">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Users</h1>
            <form class="d-flex" method="GET">
                <input name="q" value="{{ $q ?? '' }}" class="form-control form-control-sm me-2"
                    placeholder="Search name or email" />
                <select name="role" class="form-select form-select-sm me-2">
                    <option value="">All roles</option>
                    <option value="user" @if (($role ?? '') == 'user') selected @endif>User</option>
                    <option value="lawyer" @if (($role ?? '') == 'lawyer') selected @endif>Lawyer</option>
                    <option value="admin" @if (($role ?? '') == 'admin') selected @endif>Admin</option>
                </select>
                <button class="btn btn-sm btn-primary">Filter</button>
            </form>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->role }}</td>
                        <td>{{ $u->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $u->id) }}"
                                class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST"
                                style="display:inline-block;" onsubmit="return confirm('Delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
@endsection
