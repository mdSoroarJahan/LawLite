<!-- Appointment Modal -->
<div class="modal fade" id="appointmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(__('messages.book_appointment')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="appointment-form">
                <div class="modal-body">
                    <input type="hidden" name="lawyer_id" id="modal-lawyer-id">
                    <div class="mb-3">
                        <label><?php echo e(__('messages.date')); ?></label>
                        <input type="date" name="date" id="appointment-date" class="form-control" required
                            min="<?php echo e(date('Y-m-d')); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><?php echo e(__('messages.time')); ?></label>
                        <input type="hidden" name="time" id="appointment-time-input" required>
                        <div id="time-slots-container" class="d-grid gap-2"
                            style="grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); max-height: 200px; overflow-y: auto;">
                            <div class="text-muted small text-center" style="grid-column: 1 / -1;">Select a date to view
                                available times</div>
                        </div>
                        <div id="slots-loading" class="text-muted small mt-2 d-none">
                            <div class="spinner-border spinner-border-sm text-primary me-1" role="status"></div>
                            Loading slots...
                        </div>
                    </div>
                    <div class="mb-3">
                        <label><?php echo e(__('messages.type')); ?></label>
                        <select name="type" class="form-control">
                            <option value="online"><?php echo e(__('messages.online')); ?></option>
                            <option value="in-person"><?php echo e(__('messages.in_person')); ?></option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label><?php echo e(__('messages.notes')); ?></label>
                        <textarea name="notes" class="form-control"></textarea>
                    </div>

                    <!-- Payment Section -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Payment Details</label>
                        <div class="p-3 bg-light rounded border">
                            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                                <span>Consultation Fee:</span>
                                <span class="fw-bold text-primary fs-5" id="consultation-fee-display">...</span>
                            </div>

                            <input type="hidden" name="payment_method" value="sslcommerz">

                            <div class="text-center p-3 bg-white rounded border">
                                <p class="mb-2 text-muted small">Secured Payment via</p>
                                <img src="https://securepay.sslcommerz.com/public/image/sslcommerz.png" alt="SSLCommerz"
                                    style="height: 30px; max-width: 100%;">
                                <div class="mt-2 small text-muted">
                                    <i class="bi bi-shield-check text-success"></i> Safe & Secure
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('messages.cancel')); ?></button>
                    <button class="btn btn-primary" type="submit" id="book-btn"><?php echo e(__('messages.book')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('appointment-form');
        const dateInput = document.getElementById('appointment-date');
        // const timeSelect = document.getElementById('appointment-time'); // Removed
        const timeInput = document.getElementById('appointment-time-input');
        const timeSlotsContainer = document.getElementById('time-slots-container');
        const loadingIndicator = document.getElementById('slots-loading');
        const lawyerIdInput = document.getElementById('modal-lawyer-id');
        const feeDisplay = document.getElementById('consultation-fee-display');
        const bookBtn = document.getElementById('book-btn');
        const paymentRadios = document.getElementsByName('payment_method');

        function csrf() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

        // Set button text
        if (bookBtn) bookBtn.textContent = 'Pay & Book Appointment';

        // Fetch slots when date changes
        dateInput?.addEventListener('change', async function() {
            const date = this.value;
            const lawyerId = lawyerIdInput.value;

            if (!date || !lawyerId) return;

            // Reset UI
            timeInput.value = '';
            timeSlotsContainer.innerHTML = '';
            loadingIndicator.classList.remove('d-none');
            feeDisplay.textContent = 'Loading...';

            try {
                const res = await fetch(`/lawyers/${lawyerId}/slots?date=${date}`);
                const data = await res.json();

                if (data.hourly_rate) {
                    feeDisplay.textContent = data.hourly_rate + ' BDT';
                } else {
                    feeDisplay.textContent = '500 BDT'; // Fallback
                }

                if (data.ok && data.slots.length > 0) {
                    data.slots.forEach(slot => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'btn btn-outline-primary btn-sm py-2';
                        btn.textContent = slot;
                        btn.onclick = function() {
                            // Remove active class from all
                            document.querySelectorAll('#time-slots-container button')
                                .forEach(b => {
                                    b.classList.remove('btn-primary', 'text-white');
                                    b.classList.add('btn-outline-primary');
                                });
                            // Add active class to clicked
                            this.classList.remove('btn-outline-primary');
                            this.classList.add('btn-primary', 'text-white');
                            // Set value
                            timeInput.value = slot;
                        };
                        timeSlotsContainer.appendChild(btn);
                    });
                } else {
                    timeSlotsContainer.innerHTML =
                        '<div class="text-muted small text-center" style="grid-column: 1 / -1;">No slots available for this date</div>';
                }
            } catch (e) {
                console.error(e);
                timeSlotsContainer.innerHTML =
                    '<div class="text-danger small text-center" style="grid-column: 1 / -1;">Error loading slots</div>';
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
                    if (result.redirect_url) {
                        // Redirect to payment gateway
                        window.location.href = result.redirect_url;
                    } else {
                        alert('<?php echo e(__('messages.appointment_booked_success')); ?>');
                        var modal = bootstrap.Modal.getInstance(document.getElementById(
                            'appointmentModal'));
                        modal.hide();
                        form.reset();
                    }
                } else {
                    alert(result.message || '<?php echo e(__('messages.booking_failed')); ?>');
                }
            } catch (e) {
                alert('<?php echo e(__('messages.network_error')); ?>');
            }
        });

        window.openAppointmentModal = function(lawyerId) {
            document.getElementById('modal-lawyer-id').value = lawyerId;
            // Reset form
            form.reset();
            timeInput.value = '';
            timeSlotsContainer.innerHTML =
                '<div class="text-muted small text-center" style="grid-column: 1 / -1;">Select a date to view available times</div>';

            const modal = new bootstrap.Modal(document.getElementById('appointmentModal'));
            modal.show();
        }

        // Handle Bootstrap modal show event to populate data from the triggering button
        const appointmentModal = document.getElementById('appointmentModal');
        if (appointmentModal) {
            appointmentModal.addEventListener('show.bs.modal', function(event) {
                // Button that triggered the modal
                const button = event.relatedTarget;
                if (button) {
                    // Extract info from data-* attributes
                    const lawyerId = button.getAttribute('data-lawyer-id');
                    const hourlyRate = button.getAttribute('data-hourly-rate');

                    if (lawyerId) {
                        document.getElementById('modal-lawyer-id').value = lawyerId;

                        // Update fee display immediately
                        const feeDisplay = document.getElementById('consultation-fee-display');
                        if (feeDisplay) {
                            feeDisplay.textContent = (hourlyRate || '500') + ' BDT';
                        }

                        // Reset fields
                        form.reset();
                        timeInput.value = '';
                        timeSlotsContainer.innerHTML =
                            '<div class="text-muted small text-center" style="grid-column: 1 / -1;">Select a date to view available times</div>';
                    }
                }
            });
        }
    });
</script>
<?php /**PATH F:\Defence\LawLite\resources\views/components/appointment_modal.blade.php ENDPATH**/ ?>