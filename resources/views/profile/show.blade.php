@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold text-primary mb-0">{{ __('messages.profile') }}</h2>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Left Column: Personal Info -->
                        <div class="col-md-4">
                            <div class="card shadow-sm h-100 border-0">
                                <div class="card-body text-center p-4">
                                    <div class="position-relative d-inline-block mb-3">
                                        @if ($user->profile_photo_path)
                                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}"
                                                alt="Profile Photo" class="rounded-circle shadow-sm object-fit-cover"
                                                style="width: 120px; height: 120px;">
                                        @else
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm mx-auto"
                                                style="width: 120px; height: 120px; font-size: 3rem;">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <label for="profile_photo"
                                            class="position-absolute bottom-0 end-0 bg-white rounded-circle shadow p-2 cursor-pointer"
                                            style="cursor: pointer;" title="Change Photo">
                                            <i class="bi bi-camera-fill text-primary"></i>
                                            <input type="file" id="profile_photo" name="profile_photo" class="d-none"
                                                accept="image/*" onchange="this.form.submit()">
                                        </label>
                                    </div>
                                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                                    <p class="text-muted mb-3">{{ $user->email }}</p>
                                    <span
                                        class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill text-uppercase">
                                        {{ $user->role }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Edit Details -->
                        <div class="col-md-8">
                            <div class="card shadow-sm border-0 mb-4">
                                <div class="card-header bg-white py-3 border-bottom">
                                    <h5 class="mb-0 fw-bold"><i
                                            class="bi bi-person-lines-fill me-2 text-primary"></i>Personal Information</h5>
                                </div>
                                <div class="card-body p-4">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium">{{ __('messages.name') }}</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ old('name', $user->name) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium">{{ __('messages.email') }}</label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ old('email', $user->email) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-medium">{{ __('messages.language') }}</label>
                                            <select name="language_preference" class="form-select">
                                                <option value="en"
                                                    {{ $user->language_preference == 'en' ? 'selected' : '' }}>
                                                    English</option>
                                                <option value="bn"
                                                    {{ $user->language_preference == 'bn' ? 'selected' : '' }}>
                                                    Bengali</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($user->role === 'lawyer')
                                <div class="card shadow-sm border-0 mb-4">
                                    <div class="card-header bg-white py-3 border-bottom">
                                        <h5 class="mb-0 fw-bold"><i
                                                class="bi bi-briefcase-fill me-2 text-primary"></i>Professional Profile</h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-medium">Bio</label>
                                            <textarea name="bio" class="form-control" rows="4" placeholder="Tell clients about yourself...">{{ old('bio', $user->lawyer->bio ?? '') }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-medium">Education / University</label>
                                            <textarea name="education" class="form-control" rows="3" placeholder="Enter each degree/university on a new line">{{ old('education', implode("\n", $user->lawyer->education ?? [])) }}</textarea>
                                            <div class="form-text">List your degrees and universities (one per line).</div>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-medium">Expertise</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i
                                                            class="bi bi-award"></i></span>
                                                    <input type="text" name="expertise" class="form-control"
                                                        value="{{ old('expertise', $user->lawyer->expertise ?? '') }}"
                                                        placeholder="e.g. Criminal Law">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-medium">Hourly Rate (BDT)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light">৳</span>
                                                    <input type="number" name="hourly_rate" class="form-control"
                                                        value="{{ old('hourly_rate', $user->lawyer->hourly_rate ?? '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-medium">City</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i
                                                            class="bi bi-geo-alt"></i></span>
                                                    <input type="text" name="city" class="form-control"
                                                        value="{{ old('city', $user->lawyer->city ?? '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-medium">License Number</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i
                                                            class="bi bi-card-heading"></i></span>
                                                    <input type="text" name="license_number" class="form-control"
                                                        value="{{ old('license_number', $user->lawyer->license_number ?? '') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex justify-content-end mb-4">
                                <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">
                                    <i class="bi bi-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Security Section -->
                <div class="row justify-content-end">
                    <div class="col-md-8">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h5 class="mb-0 fw-bold"><i class="bi bi-shield-lock-fill me-2 text-primary"></i>Security
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <form method="POST" action="{{ route('profile.password.update') }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-4">
                                            <label class="form-label fw-medium">Current Password</label>
                                            <input type="password" name="current_password" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-medium">New Password</label>
                                            <input type="password" name="password" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-medium">Confirm Password</label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    @error('current_password')
                                        <div class="text-danger mt-2 small">{{ $message }}</div>
                                    @enderror
                                    @error('password')
                                        <div class="text-danger mt-2 small">{{ $message }}</div>
                                    @enderror

                                    <div class="mt-3 text-end">
                                        <button type="submit" class="btn btn-secondary">
                                            Update Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
