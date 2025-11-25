<!-- Appointment Modal -->
<div class="modal fade" id="appointmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.book_appointment') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="appointment-form">
                <div class="modal-body">
                    <input type="hidden" name="lawyer_id" id="modal-lawyer-id">
                    <div class="mb-3">
                        <label>{{ __('messages.date') }}</label>
                        <input type="date" name="date" id="appointment-date" class="form-control" required
                            min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <label>{{ __('messages.time') }}</label>
                        <select name="time" id="appointment-time" class="form-control" required disabled>
                            <option value="">Select a date first</option>
                        </select>
                        <div id="slots-loading" class="text-muted small mt-1 d-none">Loading slots...</div>
                    </div>
                    <div class="mb-3">
                        <label>{{ __('messages.type') }}</label>
                        <select name="type" class="form-control">
                            <option value="online">{{ __('messages.online') }}</option>
                            <option value="in-person">{{ __('messages.in_person') }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>{{ __('messages.notes') }}</label>
                        <textarea name="notes" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                    <button class="btn btn-primary" type="submit">{{ __('messages.book') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('appointment-form');
        const dateInput = document.getElementById('appointment-date');
        const timeSelect = document.getElementById('appointment-time');
        const loadingIndicator = document.getElementById('slots-loading');
        const lawyerIdInput = document.getElementById('modal-lawyer-id');

        function csrf() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

        // Fetch slots when date changes
        dateInput?.addEventListener('change', async function() {
            const date = this.value;
            const lawyerId = lawyerIdInput.value;

            if (!date || !lawyerId) return;

            timeSelect.disabled = true;
            timeSelect.innerHTML = '<option value="">Loading...</option>';
            loadingIndicator.classList.remove('d-none');

            try {
                const res = await fetch(`/lawyers/${lawyerId}/slots?date=${date}`);
                const data = await res.json();

                timeSelect.innerHTML = '<option value="">Select a time</option>';

                if (data.ok && data.slots.length > 0) {
                    data.slots.forEach(slot => {
                        const option = document.createElement('option');
                        option.value = slot;
                        option.textContent = slot;
                        timeSelect.appendChild(option);
                    });
                    timeSelect.disabled = false;
                } else {
                    timeSelect.innerHTML = '<option value="">No slots available</option>';
                }
            } catch (e) {
                console.error(e);
                timeSelect.innerHTML = '<option value="">Error loading slots</option>';
            } finally {
                loadingIndicator.classList.add('d-none');
            }
        });

        form?.addEventListener('submit', async function(e) {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(form));

            // Basic validation
            if (!data.time) {
                alert('Please select a time slot.');
                return;
            }

            try {
                const res = await fetch('/appointments/book', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf(),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await res.json();

                if (res.ok) {
                    alert('{{ __('messages.appointment_booked_success') }}');
                    var modal = bootstrap.Modal.getInstance(document.getElementById(
                        'appointmentModal'));
                    modal.hide();
                    form.reset();
                } else {
                    alert(result.message || '{{ __('messages.booking_failed') }}');
                }
            } catch (e) {
                alert('{{ __('messages.network_error') }}');
            }
        });

        window.openAppointmentModal = function(lawyerId) {
            document.getElementById('modal-lawyer-id').value = lawyerId;
            // Reset form
            form.reset();
            timeSelect.innerHTML = '<option value="">Select a date first</option>';
            timeSelect.disabled = true;

            const modal = new bootstrap.Modal(document.getElementById('appointmentModal'));
            modal.show();
        }
    });
</script>
