@extends('layouts.app')

@section('content')
    <h1>Lawyer Analytics</h1>
    <p>Appointments, messages, response time overview.</p>
    <div class="row">
        <div class="col-md-4">
            <div class="card p-3">Appointments: <strong>12</strong></div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">Messages: <strong>34</strong></div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">Avg response: <strong>2h 15m</strong></div>
        </div>
    </div>
@endsection
