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
