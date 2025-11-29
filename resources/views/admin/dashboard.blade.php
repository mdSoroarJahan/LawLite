@extends('layouts.app')

@section('content')
    <div class="container py-6">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <h1>Admin Dashboard</h1>
                <div class="list-group">
                    <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action">Manage Users</a>
                    <a href="{{ route('admin.verification.index') }}" class="list-group-item list-group-item-action">Manage
                        Lawyers</a>
                    <a href="{{ route('admin.articles.index') }}" class="list-group-item list-group-item-action">Manage
                        Articles</a>
                    <a href="{{ url('/_dev/login-as/admin') }}"
                        class="list-group-item list-group-item-action text-warning">Dev: Login as admin</a>
                </div>
            </div>
        </div>
    </div>
@endsection
