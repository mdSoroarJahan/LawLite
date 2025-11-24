@extends('layouts.app')

@section('content')
    <div class="container py-6">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1>{{ __('messages.profile') }}</h1>
                <table class="table">
                    <tr>
                        <th>{{ __('messages.name') }}</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('messages.email') }}</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('messages.role') }}</th>
                        <td>{{ $user->role }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('messages.language') }}</th>
                        <td>{{ $user->language_preference }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
