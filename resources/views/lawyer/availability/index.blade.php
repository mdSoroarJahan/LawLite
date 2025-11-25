@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Manage Availability</h1>
            <a href="{{ route('lawyer.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('lawyer.availability.update') }}" method="POST">
                    @csrf

                    <div id="schedule-container">
                        @php
                            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                        @endphp

                        @foreach ($days as $day)
                            <div class="mb-4 border-bottom pb-3">
                                <h5 class="text-capitalize mb-3">{{ $day }}</h5>

                                <div class="day-slots" data-day="{{ $day }}">
                                    @php
                                        $daySlots = $availabilities->where('day_of_week', $day);
                                    @endphp

                                    @foreach ($daySlots as $index => $slot)
                                        <div class="row g-2 mb-2 align-items-center slot-row">
                                            <input type="hidden"
                                                name="schedule[{{ $loop->parent->index * 100 + $index }}][day_of_week]"
                                                value="{{ $day }}">
                                            <div class="col-auto">
                                                <input type="time"
                                                    name="schedule[{{ $loop->parent->index * 100 + $index }}][start_time]"
                                                    class="form-control"
                                                    value="{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}"
                                                    required>
                                            </div>
                                            <div class="col-auto">
                                                <span>to</span>
                                            </div>
                                            <div class="col-auto">
                                                <input type="time"
                                                    name="schedule[{{ $loop->parent->index * 100 + $index }}][end_time]"
                                                    class="form-control"
                                                    value="{{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}"
                                                    required>
                                            </div>
                                            <div class="col-auto">
                                                <button type="button" class="btn btn-outline-danger btn-sm remove-slot">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                            <!-- Hidden inputs for array structure if needed, but name="schedule[]" works if we process carefully -->
                                            <!-- Actually, to keep indices unique for validation, we need explicit indices or just handle array submission -->
                                            <!-- Let's use a JS helper to re-index before submit or just use array[] and handle in controller -->
                                        </div>
                                    @endforeach
                                </div>

                                <button type="button" class="btn btn-sm btn-outline-primary add-slot-btn"
                                    data-day="{{ $day }}">
                                    <i class="bi bi-plus"></i> Add Slot
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Save Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <template id="slot-template">
        <div class="row g-2 mb-2 align-items-center slot-row">
            <input type="hidden" class="day-input" name="schedule[INDEX][day_of_week]" value="">
            <div class="col-auto">
                <input type="time" name="schedule[INDEX][start_time]" class="form-control" required>
            </div>
            <div class="col-auto">
                <span>to</span>
            </div>
            <div class="col-auto">
                <input type="time" name="schedule[INDEX][end_time]" class="form-control" required>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-outline-danger btn-sm remove-slot">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let slotCounter = 1000; // Start high to avoid conflict with existing

            // Add Slot
            document.querySelectorAll('.add-slot-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const day = this.dataset.day;
                    const container = this.previousElementSibling; // .day-slots
                    const template = document.getElementById('slot-template').content.cloneNode(
                        true);

                    // Update inputs
                    template.querySelector('.day-input').value = day;

                    // Replace INDEX placeholder
                    template.querySelectorAll('[name*="INDEX"]').forEach(input => {
                        input.name = input.name.replace('INDEX', slotCounter);
                    });

                    slotCounter++;
                    container.appendChild(template);
                });
            });

            // Remove Slot (Event Delegation)
            document.getElementById('schedule-container').addEventListener('click', function(e) {
                if (e.target.closest('.remove-slot')) {
                    e.target.closest('.slot-row').remove();
                }
            });
        });
    </script>
@endsection
