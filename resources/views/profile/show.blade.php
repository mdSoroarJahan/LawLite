@extends('layouts.app')

@section('content')
    <div class="container py-6">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1>{{ __('messages.profile') }}</h1>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card mb-4">
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3 text-center">
                                @if ($user->profile_photo_path)
                                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Photo"
                                        class="rounded-circle mb-2" style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center text-white mb-2"
                                        style="width: 100px; height: 100px; font-size: 2rem;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <label class="form-label">Change Photo</label>
                                    <input type="file" name="profile_photo" class="form-control" accept="image/*">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.name') }}</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.email') }}</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.role') }}</label>
                                <input type="text" class="form-control" value="{{ $user->role }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.language') }}</label>
                                <select name="language_preference" class="form-select">
                                    <option value="en" {{ $user->language_preference == 'en' ? 'selected' : '' }}>
                                        English</option>
                                    <option value="bn" {{ $user->language_preference == 'bn' ? 'selected' : '' }}>
                                        Bengali</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Change Password</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="current_password" class="form-control" required>
                                @error('current_password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control" required>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-secondary">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
