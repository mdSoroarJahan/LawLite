@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">{{ __('messages.notifications') }}</h1>

        @if ($notifications->isEmpty())
            <div class="alert alert-info">
                <p class="mb-0">{{ __('messages.no_notifications_yet') }}</p>
            </div>
        @else
            <div class="list-group">
                @foreach ($notifications as $notification)
                    <div class="list-group-item {{ $notification->read_at ? '' : 'list-group-item-primary' }}">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">
                                @if (!$notification->read_at)
                                    <span class="badge bg-primary me-2">{{ __('messages.new') }}</span>
                                @endif
                                {{ $notification->data['title'] ?? __('messages.notification') }}
                            </h6>
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1">{{ $notification->data['message'] ?? __('messages.new_notification_message') }}
                        </p>
                        @if (!$notification->read_at)
                            <form method="POST" action="{{ route('notifications.mark-read', $notification->id) }}"
                                class="d-inline">
                                @csrf
                                <button type="submit"
                                    class="btn btn-sm btn-link p-0">{{ __('messages.mark_as_read') }}</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-3">
                {{ $notifications->links() }}
            </div>

            @if ($notifications->where('read_at', null)->count() > 0)
                <div class="mt-3">
                    <form method="POST" action="{{ route('notifications.mark-all-read') }}">
                        @csrf
                        <button type="submit"
                            class="btn btn-sm btn-secondary">{{ __('messages.mark_all_as_read') }}</button>
                    </form>
                </div>
            @endif
        @endif
    </div>
@endsection
