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
                        <input type="date" name="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>{{ __('messages.time') }}</label>
                        <input type="time" name="time" class="form-control" required>
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

        function csrf() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

        form?.addEventListener('submit', async function(e) {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(form));
            try {
                const res = await fetch('/appointments/book', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf()
                    },
                    body: new URLSearchParams(data)
                });
                if (res.ok) {
                    alert('{{ __('messages.appointment_booked_success') }}');
                } else {
                    alert('{{ __('messages.booking_failed') }}');
                }
            } catch (e) {
                alert('{{ __('messages.network_error') }}');
            }
            var modal = bootstrap.Modal.getInstance(document.getElementById('appointmentModal'));
            modal.hide();
        });

        window.openAppointmentModal = function(lawyerId) {
            document.getElementById('modal-lawyer-id').value = lawyerId;
            const modal = new bootstrap.Modal(document.getElementById('appointmentModal'));
            modal.show();
        }
    });
</script>
