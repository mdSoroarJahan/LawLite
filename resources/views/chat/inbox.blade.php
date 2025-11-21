@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Messages</h1>

        @if($conversations->isEmpty())
            <div class="alert alert-info">
                <p class="mb-0">No messages yet. Start a conversation by messaging a lawyer from their profile.</p>
            </div>
        @else
            <div class="list-group">
                @foreach($conversations as $conversation)
                    <a href="javascript:void(0)" 
                       onclick="openChatWith({{ $conversation['partner']->id }})"
                       class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">
                                {{ $conversation['partner']->name }}
                                @if($conversation['unread_count'] > 0)
                                    <span class="badge bg-primary">{{ $conversation['unread_count'] }}</span>
                                @endif
                            </h5>
                            <small class="text-muted">{{ $conversation['latest_message']->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1 text-muted">
                            @if($conversation['latest_message']->sender_id === auth()->id())
                                <strong>You:</strong>
                            @endif
                            {{ Str::limit($conversation['latest_message']->content, 80) }}
                        </p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
