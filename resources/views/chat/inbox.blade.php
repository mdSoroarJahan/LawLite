@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">{{ __('messages.messages') }}</h1>

        <!-- Search Bar -->
        <div class="row mb-4">
            <div class="col-md-8">
                <form method="GET" action="{{ route('messages.inbox') }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search conversations by name..." 
                               value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">{{ __('messages.search') }}</button>
                        @if(request('search'))
                            <a href="{{ route('messages.inbox') }}" class="btn btn-secondary">Clear</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        @if ($conversations->isEmpty())
            <div class="alert alert-info">
                <p class="mb-0">{{ __('messages.no_messages') }}</p>
            </div>
        @else
            <div class="list-group">
                @foreach ($conversations as $conversation)
                    <a href="javascript:void(0)" onclick="openChatWith({{ $conversation['partner']->id }})"
                        class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">
                                {{ $conversation['partner']->name }}
                                @if ($conversation['unread_count'] > 0)
                                    <span class="badge bg-primary">{{ $conversation['unread_count'] }}</span>
                                @endif
                            </h5>
                            <small
                                class="text-muted">{{ $conversation['latest_message']->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1 text-muted">
                            @if ($conversation['latest_message']->sender_id === auth()->id())
                                <strong>You:</strong>
                            @endif
                            {{ \Illuminate\Support\Str::limit($conversation['latest_message']->content, 80) }}
                        </p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
