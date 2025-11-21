@extends('layouts.app')

@section('content')
    <div class="container py-6">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <h3 class="mb-3">{{ __('messages.login') }}</h3>
                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif
                        <div class="mb-3">
                            <label>{{ __('messages.email') }}</label>
                            <input name="email" value="{{ old('email') }}" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>{{ __('messages.password') }}</label>
                            <input name="password" type="password" class="form-control" />
                        </div>
                        <button class="btn btn-primary">{{ __('messages.login') }}</button>

                        @if (env('APP_ENV') === 'local')
                            <hr class="my-3">
                            <div class="small text-muted">Quick sign-in (development only):</div>
                            <div class="d-flex gap-2 mt-2">
                                <a href="{{ url('/_dev/login-as/admin') }}" class="btn btn-sm btn-outline-secondary">Sign in
                                    as Admin</a>
                                <a href="{{ url('/_dev/login-as/lawyer') }}" class="btn btn-sm btn-outline-secondary">Sign
                                    in as Lawyer</a>
                                <a href="{{ url('/_dev/login-as/user') }}" class="btn btn-sm btn-outline-secondary">Sign in
                                    as User</a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
