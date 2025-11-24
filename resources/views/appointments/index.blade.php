@extends('layouts.app')

@section('content')
    <div class="container py-6 text-center">
        <h1 class="display-6">{{ __('messages.appointments') }}</h1>
        <p class="text-muted">{{ __('messages.book_appointment_description') }}</p>
    </div>
@endsection
