@extends('layouts.landing')

@section('content')
    <style>
        /* ===== MODERN PROFESSIONAL PROFILE THEME ===== */
        .profile-header {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .profile-title {
            color: #10b981;
            font-weight: 700;
        }
        .glass-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        .glass-card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            border-color: rgba(16, 185, 129, 0.3);
        }
        .glass-header {
            background: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
            padding: 1.25rem 1.5rem;
        }
        .glass-header h5 {
            color: #10b981;
        }
        .profile-photo-wrapper {
            position: relative;
            display: inline-block;
        }
        .profile-photo-wrapper img,
        .profile-photo-wrapper .avatar-placeholder {
            border: 4px solid rgba(16, 185, 129, 0.2);
            transition: all 0.3s ease;
        }
        .profile-photo-wrapper:hover img,
        .profile-photo-wrapper:hover .avatar-placeholder {
            border-color: #10b981;
            transform: scale(1.02);
        }
        .avatar-placeholder {
            background: #10b981 !important;
        }
        .role-badge {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        .premium-input {
            background: #ffffff;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.25s ease;
            color: #1f2937;
        }
        .premium-input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
            background: white;
            outline: none;
        }
        .premium-select {
            background: #ffffff;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.25s ease;
            color: #1f2937;
        }
        .premium-select:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
            outline: none;
        }
        .input-icon {
            background: rgba(16, 185, 129, 0.1);
            border: 2px solid #e5e7eb;
            border-right: none;
            border-radius: 10px 0 0 10px;
            color: #10b981;
        }
        .save-btn {
            background: #10b981;
            border: none;
            border-radius: 10px;
            padding: 0.875rem 2rem;
            font-weight: 600;
            color: white;
            transition: all 0.25s ease;
        }
        .save-btn:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        }
        .security-card .glass-header {
            background: #fef2f2;
        }
        .security-card .glass-header h5 {
            color: #dc2626;
        }
        .password-btn {
            background: #64748b;
            border: none;
            border-radius: 10px;
            transition: all 0.25s ease;
            color: white;
        }
        .password-btn:hover {
            background: #475569;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(100, 116, 139, 0.3);
        }
        .camera-btn {
            background: white;
            border: 2px solid rgba(16, 185, 129, 0.3);
            border-radius: 50%;
            padding: 0.5rem;
            transition: all 0.25s ease;
        }
        .camera-btn:hover {
            background: #10b981;
            border-color: #10b981;
        }
        .camera-btn:hover i {
            color: white !important;
        }
        .camera-btn i {
            color: #10b981 !important;
        }
        .form-label {
            color: #374151;
        }
        
        /* ===== DARK MODE ===== */
        html[data-theme="dark"] .profile-header {
            background: #1e293b;
            border-color: #334155;
        }
        html[data-theme="dark"] .profile-title {
            color: #34d399;
        }
        html[data-theme="dark"] .glass-card {
            background: #1e293b;
            border-color: #334155;
        }
        html[data-theme="dark"] .glass-card:hover {
            border-color: rgba(52, 211, 153, 0.3);
        }
        html[data-theme="dark"] .glass-header {
            background: #0f172a;
            border-bottom-color: #334155;
        }
        html[data-theme="dark"] .glass-header h5 {
            color: #34d399;
        }
        html[data-theme="dark"] .profile-photo-wrapper img,
        html[data-theme="dark"] .profile-photo-wrapper .avatar-placeholder {
            border-color: rgba(52, 211, 153, 0.3);
        }
        html[data-theme="dark"] .profile-photo-wrapper:hover img,
        html[data-theme="dark"] .profile-photo-wrapper:hover .avatar-placeholder {
            border-color: #34d399;
        }
        html[data-theme="dark"] .role-badge {
            background: rgba(52, 211, 153, 0.1);
            color: #34d399;
            border-color: rgba(52, 211, 153, 0.2);
        }
        html[data-theme="dark"] .premium-input,
        html[data-theme="dark"] .premium-select {
            background: #0f172a;
            border-color: #334155;
            color: #f1f5f9;
        }
        html[data-theme="dark"] .premium-input:focus,
        html[data-theme="dark"] .premium-select:focus {
            border-color: #34d399;
            box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.15);
        }
        html[data-theme="dark"] .input-icon {
            background: rgba(52, 211, 153, 0.1);
            border-color: #334155;
            color: #34d399;
        }
        html[data-theme="dark"] .form-label {
            color: #e2e8f0;
        }
        html[data-theme="dark"] .text-muted {
            color: #94a3b8 !important;
        }
        html[data-theme="dark"] h5.fw-bold {
            color: #f1f5f9;
        }
        html[data-theme="dark"] .security-card .glass-header {
            background: rgba(220, 38, 38, 0.1);
        }
        html[data-theme="dark"] .security-card .glass-header h5 {
            color: #f87171;
        }
        html[data-theme="dark"] .camera-btn {
            background: #1e293b;
            border-color: rgba(52, 211, 153, 0.3);
        }
        html[data-theme="dark"] .camera-btn i {
            color: #34d399 !important;
        }
        html[data-theme="dark"] .camera-btn:hover {
            background: #10b981;
        }
        html[data-theme="dark"] .camera-btn:hover i {
            color: white !important;
        }
        html[data-theme="dark"] .alert-success {
            background: rgba(16, 185, 129, 0.15);
            border-color: rgba(16, 185, 129, 0.3);
            color: #34d399;
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="profile-header reveal">
                    <h2 class="fw-bold profile-title mb-0">{{ __('messages.profile') }}</h2>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm reveal" role="alert">
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
                            <div class="glass-card h-100 reveal">
                                <div class="card-body text-center p-4">
                                    <div class="profile-photo-wrapper mb-3">
                                        @if ($user->profile_photo_path)
                                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}"
                                                alt="Profile Photo" class="rounded-circle shadow object-fit-cover"
                                                style="width: 120px; height: 120px;">
                                        @else
                                            <div class="rounded-circle avatar-placeholder text-white d-flex align-items-center justify-content-center shadow mx-auto"
                                                style="width: 120px; height: 120px; font-size: 3rem;">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <label for="profile_photo"
                                            class="position-absolute bottom-0 end-0 camera-btn shadow"
                                            style="cursor: pointer;" title="Change Photo">
                                            <i class="bi bi-camera-fill text-primary"></i>
                                            <input type="file" id="profile_photo" name="profile_photo" class="d-none"
                                                accept="image/*" onchange="this.form.submit()">
                                        </label>
                                    </div>
                                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                                    <p class="text-muted mb-3">{{ $user->email }}</p>
                                    <span class="role-badge">{{ $user->role }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Edit Details -->
                        <div class="col-md-8">
                            <div class="glass-card mb-4 reveal" style="animation-delay: 0.1s;">
                                <div class="glass-header">
                                    <h5 class="mb-0 fw-bold"><i class="bi bi-person-lines-fill me-2"></i>Personal Information</h5>
                                </div>
                                <div class="card-body p-4">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold small">{{ __('messages.name') }}</label>
                                            <input type="text" name="name" class="form-control premium-input"
                                                value="{{ old('name', $user->name) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold small">{{ __('messages.email') }}</label>
                                            <input type="email" name="email" class="form-control premium-input"
                                                value="{{ old('email', $user->email) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold small">{{ __('messages.language') }}</label>
                                            <select name="language_preference" class="form-select premium-select">
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
                                <div class="glass-card mb-4 reveal" style="animation-delay: 0.2s;">
                                    <div class="glass-header">
                                        <h5 class="mb-0 fw-bold"><i class="bi bi-briefcase-fill me-2"></i>Professional Profile</h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold small">Bio</label>
                                            <textarea name="bio" class="form-control premium-input" rows="4" placeholder="Tell clients about yourself...">{{ old('bio', $user->lawyer->bio ?? '') }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold small">Education / University</label>
                                            <textarea name="education" class="form-control premium-input" rows="3" placeholder="Enter each degree/university on a new line">{{ old('education', implode("\n", $user->lawyer->education ?? [])) }}</textarea>
                                            <div class="form-text">List your degrees and universities (one per line).</div>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold small">Expertise</label>
                                                <div class="input-group">
                                                    <span class="input-group-text input-icon"><i class="bi bi-award"></i></span>
                                                    <input type="text" name="expertise" class="form-control premium-input" style="border-radius: 0 12px 12px 0;"
                                                        value="{{ old('expertise', $user->lawyer->expertise ?? '') }}"
                                                        placeholder="e.g. Criminal Law">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold small">Hourly Rate (BDT)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text input-icon">৳</span>
                                                    <input type="number" name="hourly_rate" class="form-control premium-input" style="border-radius: 0 12px 12px 0;"
                                                        value="{{ old('hourly_rate', $user->lawyer->hourly_rate ?? '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold small">City</label>
                                                <div class="input-group">
                                                    <span class="input-group-text input-icon"><i class="bi bi-geo-alt"></i></span>
                                                    <input type="text" name="city" class="form-control premium-input" style="border-radius: 0 12px 12px 0;"
                                                        value="{{ old('city', $user->lawyer->city ?? '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold small">License Number</label>
                                                <div class="input-group">
                                                    <span class="input-group-text input-icon"><i class="bi bi-card-heading"></i></span>
                                                    <input type="text" name="license_number" class="form-control premium-input" style="border-radius: 0 12px 12px 0;"
                                                        value="{{ old('license_number', $user->lawyer->license_number ?? '') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex justify-content-end mb-4">
                                <button type="submit" class="btn btn-primary save-btn">
                                    <i class="bi bi-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Security Section -->
                <div class="row justify-content-end">
                    <div class="col-md-8">
                        <div class="glass-card security-card reveal" style="animation-delay: 0.3s;">
                            <div class="glass-header">
                                <h5 class="mb-0 fw-bold"><i class="bi bi-shield-lock-fill me-2"></i>Security</h5>
                            </div>
                            <div class="card-body p-4">
                                <form method="POST" action="{{ route('profile.password.update') }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold small">Current Password</label>
                                            <input type="password" name="current_password" class="form-control premium-input" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold small">New Password</label>
                                            <input type="password" name="password" class="form-control premium-input" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold small">Confirm Password</label>
                                            <input type="password" name="password_confirmation" class="form-control premium-input" required>
                                        </div>
                                    </div>
                                    @error('current_password')
                                        <div class="text-danger mt-2 small">{{ $message }}</div>
                                    @enderror
                                    @error('password')
                                        <div class="text-danger mt-2 small">{{ $message }}</div>
                                    @enderror

                                    <div class="mt-3 text-end">
                                        <button type="submit" class="btn btn-secondary password-btn px-4">
                                            <i class="bi bi-key me-2"></i>Update Password
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
