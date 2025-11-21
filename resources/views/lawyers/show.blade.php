@extends('layouts.app')

@section('content')
    <div class="container py-6">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1>{{ $lawyer->name ?? 'Lawyer' }}</h1>
                <p class="text-muted">{{ $lawyer->specialty ?? 'General practice' }}</p>
                <p>Location: {{ $lawyer->city ?? 'Unknown' }}</p>
                @auth
                    <button class="btn btn-primary" onclick="openChatWith({{ $lawyer->user_id ?? 0 }})">Message</button>
                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#appointmentModal"
                        data-lawyer-id="{{ $lawyer->id }}" data-lawyer-name="{{ $lawyer->name ?? 'Lawyer' }}">Book
                        appointment</button>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Sign in to Message</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary">Sign in to Book</a>
                @endauth
            </div>
        </div>
    </div>
@endsection
