@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h4 fw-bold mb-0">{{ __('messages.notifications') }}</h2>
                    @if ($notifications->where('read_at', null)->count() > 0)
                        <form method="POST" action="{{ route('notifications.mark-all-read') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="bi bi-check-all me-1"></i> {{ __('messages.mark_all_as_read') }}
                            </button>
                        </form>
                    @endif
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        @if ($notifications->isEmpty())
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-bell-slash display-4 text-muted opacity-50"></i>
                                </div>
                                <h5 class="text-muted fw-normal">{{ __('messages.no_notifications_yet') }}</h5>
                            </div>
                        @else
                            <div class="list-group list-group-flush">
                                @foreach ($notifications as $notification)
                                    @php
                                        $type = $notification->data['type'] ?? '';
                                        $url = route('notifications.read', $notification->id);
                                        $icon = 'bi-bell';
                                        $color = 'primary';

                                        if ($type === 'appointment') {
                                            $icon = 'bi-calendar-check';
                                            $color = 'info';
                                        } elseif ($type === 'message') {
                                            $icon = 'bi-chat-dots';
                                            $color = 'success';
                                        }
                                    @endphp

                                    <div
                                        class="list-group-item list-group-item-action p-4 border-bottom {{ $notification->read_at ? 'bg-white' : 'bg-light' }}">
                                        <div class="d-flex align-items-start">
                                            <!-- Icon -->
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm rounded-circle bg-{{ $color }}-subtle text-{{ $color }} d-flex align-items-center justify-content-center"
                                                    style="width: 48px; height: 48px;">
                                                    <i class="bi {{ $icon }} fs-5"></i>
                                                </div>
                                            </div>

                                            <!-- Content -->
                                            <div class="flex-grow-1 min-w-0">
                                                <a href="{{ $url }}"
                                                    class="text-decoration-none text-dark stretched-link">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <h6
                                                            class="mb-0 fw-bold {{ $notification->read_at ? 'text-muted' : 'text-dark' }}">
                                                            {{ $notification->data['title'] ?? __('messages.notification') }}
                                                            @if (!$notification->read_at)
                                                                <span class="badge bg-danger rounded-pill ms-2"
                                                                    style="font-size: 0.6rem;">New</span>
                                                            @endif
                                                        </h6>
                                                        <small
                                                            class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                    </div>
                                                    <p class="mb-0 text-secondary text-truncate">
                                                        {{ $notification->data['message'] ?? __('messages.new_notification_message') }}
                                                    </p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    @if ($notifications->hasPages())
                        <div class="card-footer bg-white border-top-0 py-3">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-primary:hover {
            color: var(--bs-primary) !important;
            background-color: var(--bs-primary-bg-subtle) !important;
        }

        .list-group-item-action:hover {
            background-color: #f8f9fa;
        }
    </style>
@endsection
