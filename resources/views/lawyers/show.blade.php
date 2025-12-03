@extends('layouts.app')

@section('content')
    <div class="container py-6">
        <div class="row">
            <div class="col-md-4 text-center">
                @if ($lawyer->user->profile_photo_path)
                    <img src="{{ asset('storage/' . $lawyer->user->profile_photo_path) }}" alt="{{ $lawyer->user->name }}"
                        class="rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                @else
                    <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center text-white mb-3"
                        style="width: 200px; height: 200px; font-size: 4rem;">
                        {{ substr($lawyer->user->name, 0, 1) }}
                    </div>
                @endif

                <h3>
                    {{ $lawyer->user->name ?? 'Lawyer' }}
                    @if ($lawyer->verification_status === 'verified')
                        <span class="badge bg-success rounded-pill fs-6 align-middle" title="Verified Lawyer">
                            <i class="bi bi-check-circle-fill"></i> Verified
                        </span>
                    @endif
                </h3>
                <p class="text-muted">{{ $lawyer->expertise ?? __('messages.general_practice') }}</p>
                <p><i class="bi bi-geo-alt-fill"></i> {{ $lawyer->city ?? __('messages.unknown') }}</p>

                <div class="d-grid gap-2">
                    @auth
                        <button class="btn btn-primary"
                            onclick="openChatWith({{ $lawyer->user_id ?? 0 }})">{{ __('messages.message') }}</button>
                        <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#appointmentModal"
                            data-lawyer-id="{{ $lawyer->id }}" data-hourly-rate="{{ $lawyer->hourly_rate ?? 500 }}"
                            data-lawyer-name="{{ $lawyer->user->name ?? 'Lawyer' }}">{{ __('messages.book_appointment') }}</button>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">{{ __('messages.sign_in_to_message') }}</a>
                        <a href="{{ route('login') }}"
                            class="btn btn-outline-secondary">{{ __('messages.sign_in_to_book') }}</a>
                    @endauth
                </div>
            </div>

            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">About</h5>
                        <p class="card-text">{{ $lawyer->bio ?? 'No biography available.' }}</p>
                    </div>
                </div>

                @if (is_array($lawyer->education) && count($lawyer->education) > 0)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Education</h5>
                            <ul class="list-group list-group-flush">
                                @foreach ($lawyer->education as $edu)
                                    <li class="list-group-item">{{ $edu }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if (is_array($lawyer->experience) && count($lawyer->experience) > 0)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Experience</h5>
                            <ul class="list-group list-group-flush">
                                @foreach ($lawyer->experience as $exp)
                                    <li class="list-group-item">{{ $exp }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if (is_array($lawyer->languages) && count($lawyer->languages) > 0)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Languages</h5>
                            <p class="card-text">{{ implode(', ', $lawyer->languages) }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
