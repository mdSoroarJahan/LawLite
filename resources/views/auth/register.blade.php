@extends('layouts.app')

@section('content')
    <div class="container py-6">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <h3 class="mb-3">{{ __('messages.register') }}</h3>
                    <form method="POST" action="{{ route('register.post') }}">
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
                        <div class="mb-3">
                            <label>{{ __('messages.name') }}</label>
                            <input name="name" value="{{ old('name') }}" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>{{ __('messages.email') }}</label>
                            <input name="email" value="{{ old('email') }}" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>{{ __('messages.password') }}</label>
                            <input name="password" type="password" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>{{ __('messages.confirm_password') }}</label>
                            <input name="password_confirmation" type="password" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>{{ __('messages.register_as') }}</label>
                            <select name="role" class="form-select">
                                <option value="user" @if (old('role', 'user') === 'user') selected @endif>
                                    {{ __('messages.user') }}
                                </option>
                                <option value="lawyer" @if (old('role') === 'lawyer') selected @endif>
                                    {{ __('messages.lawyer') }}
                                </option>
                            </select>
                            <div class="form-text">If you are a practicing lawyer, choose "Register as Lawyer". Lawyers will
                                be reviewed by admins before verification.</div>
                        </div>

                        <button class="btn btn-primary">{{ __('messages.register') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
