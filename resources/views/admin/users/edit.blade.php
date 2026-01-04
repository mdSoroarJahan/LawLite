@extends('layouts.app')

@section('content')
    <div class="container py-6">
        <h1>Edit User</h1>
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Name</label>
                <input name="name" value="{{ old('name', $user->name) }}" class="form-control" />
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input name="email" value="{{ old('email', $user->email) }}" class="form-control" />
            </div>
            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-select">
                    <option value="user" @if ($user->role == 'user') selected @endif>User</option>
                    <option value="lawyer" @if ($user->role == 'lawyer') selected @endif>Lawyer</option>
                    <option value="admin" @if ($user->role == 'admin') selected @endif>Admin</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Language</label>
                <input name="language_preference" value="{{ old('language_preference', $user->language_preference) }}"
                    class="form-control" />
            </div>
            <div class="mb-3">
                <label>New Password (leave blank to keep)</label>
                <input name="password" type="password" class="form-control" />
            </div>
            <div class="mb-3">
                <label>Confirm Password</label>
                <input name="password_confirmation" type="password" class="form-control" />
            </div>
            <button class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
