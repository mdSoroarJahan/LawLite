@extends('layouts.app')

@section('content')
    <div class="container py-6">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <h1>Admin Dashboard</h1>
                <div class="list-group">
                    <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action">Manage Users</a>
                    <a href="#" class="list-group-item list-group-item-action">Manage Lawyers</a>
                    <a href="#" class="list-group-item list-group-item-action">Manage Articles</a>
                    <a href="{{ url('/_dev/login-as/admin') }}"
                        class="list-group-item list-group-item-action text-warning">Dev: Login as admin</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container py-6">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <h1>Admin Dashboard</h1>
                <p class="text-muted">Placeholder admin area. Protect this route and implement analytics and management
                    tools
                    here.</p>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <h1>Admin Dashboard</h1>
    <p>Summary stats, verification queue, content management links.</p>
    <div class="card">
        <div class="card-body">
            <ul>
                <li><a href="#">Lawyer Verifications</a></li>
                <li><a href="#">Manage Articles</a></li>
                <li><a href="#">AI Query Logs</a></li>
            </ul>
        </div>
    </div>
@endsection
