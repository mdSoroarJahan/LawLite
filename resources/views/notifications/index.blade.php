@extends('layouts.app')

@section('content')
    <style>
        .notifications-header {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.08) 0%, rgba(239, 68, 68, 0.08) 50%, rgba(79, 70, 229, 0.06) 100%);
            border-radius: 24px;
            padding: 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }
        .notifications-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.15) 0%, transparent 70%);
        }
        .notifications-title {
            background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .mark-all-btn {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            border: none;
            border-radius: 50px;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .mark-all-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.35);
        }
        .notifications-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        .notification-item {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .notification-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 0;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            transition: width 0.3s ease;
        }
        .notification-item:hover {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.05) 0%, rgba(239, 68, 68, 0.05) 100%);
            transform: translateX(4px);
        }
        .notification-item:hover::before {
            width: 4px;
        }
        .notification-item.unread {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.08) 0%, rgba(239, 68, 68, 0.05) 100%);
        }
        .notification-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            transition: all 0.3s ease;
        }
        .notification-item:hover .notification-icon {
            transform: scale(1.1);
        }
        .icon-appointment {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.15) 100%);
            color: #3b82f6;
        }
        .icon-message {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
            color: #10b981;
        }
        .icon-default {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(217, 119, 6, 0.15) 100%);
            color: #f59e0b;
        }
        .new-badge {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            font-size: 0.65rem;
            padding: 0.25rem 0.5rem;
            border-radius: 50px;
        }
        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }
        .empty-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(239, 68, 68, 0.1) 100%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        html[data-theme="dark"] .notifications-header {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(239, 68, 68, 0.12) 50%, rgba(79, 70, 229, 0.1) 100%);
        }
        html[data-theme="dark"] .notifications-card {
            background: rgba(30, 41, 59, 0.85);
            border-color: rgba(255, 255, 255, 0.1);
        }
        html[data-theme="dark"] .notification-item {
            border-color: rgba(255, 255, 255, 0.05);
        }
        html[data-theme="dark"] .notification-item.unread {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(239, 68, 68, 0.1) 100%);
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="notifications-header reveal d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <h2 class="h4 fw-bold mb-0 notifications-title">{{ __('messages.notifications') }}</h2>
                    @if ($notifications->where('read_at', null)->count() > 0)
                        <form method="POST" action="{{ route('notifications.mark-all-read') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary mark-all-btn">
                                <i class="bi bi-check-all me-1"></i> {{ __('messages.mark_all_as_read') }}
                            </button>
                        </form>
                    @endif
                </div>

                <div class="notifications-card reveal" style="animation-delay: 0.1s;">
                    @if ($notifications->isEmpty())
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="bi bi-bell-slash" style="font-size: 2.5rem; color: #f59e0b;"></i>
                            </div>
                            <h5 class="fw-bold mb-2">No Notifications Yet</h5>
                            <p class="text-muted mb-0">{{ __('messages.no_notifications_yet') }}</p>
                        </div>
                    @else
                        @foreach ($notifications as $notification)
                            @php
                                $type = $notification->data['type'] ?? '';
                                $url = route('notifications.read', $notification->id);
                                $icon = 'bi-bell';
                                $iconClass = 'icon-default';

                                if ($type === 'appointment') {
                                    $icon = 'bi-calendar-check';
                                    $iconClass = 'icon-appointment';
                                } elseif ($type === 'message') {
                                    $icon = 'bi-chat-dots';
                                    $iconClass = 'icon-message';
                                }
                            @endphp

                            <a href="{{ $url }}" class="text-decoration-none">
                                <div class="notification-item d-flex align-items-start {{ $notification->read_at ? '' : 'unread' }}">
                                    <div class="notification-icon {{ $iconClass }} me-3 flex-shrink-0">
                                        <i class="bi {{ $icon }}"></i>
                                    </div>
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold {{ $notification->read_at ? 'text-muted' : '' }}">
                                                {{ $notification->data['title'] ?? __('messages.notification') }}
                                                @if (!$notification->read_at)
                                                    <span class="badge new-badge text-white ms-2">New</span>
                                                @endif
                                            </h6>
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-0 text-muted text-truncate">
                                            {{ $notification->data['message'] ?? __('messages.new_notification_message') }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @endif
                    
                    @if ($notifications->hasPages())
                        <div class="p-3 border-top" style="border-color: rgba(0,0,0,0.05) !important;">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
