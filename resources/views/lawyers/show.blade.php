@extends('layouts.app')

@section('content')
    <div class="container py-6">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1>{{ $lawyer->user->name ?? 'Lawyer' }}</h1>
                <p class="text-muted">{{ $lawyer->expertise ?? __('messages.general_practice') }}</p>
                <p>{{ __('messages.location') }}: {{ $lawyer->city ?? __('messages.unknown') }}</p>
                @auth
                    <button class="btn btn-primary"
                        onclick="openChatWith({{ $lawyer->user_id ?? 0 }})">{{ __('messages.message') }}</button>
                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#appointmentModal"
                        data-lawyer-id="{{ $lawyer->id }}"
                        data-lawyer-name="{{ $lawyer->user->name ?? 'Lawyer' }}">{{ __('messages.book_appointment') }}</button>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">{{ __('messages.sign_in_to_message') }}</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary">{{ __('messages.sign_in_to_book') }}</a>
                @endauth
            </div>
        </div>
    </div>
@endsection
