

<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <h2 class="mb-4"><?php echo e(__('messages.my_invoices')); ?></h2>

        <?php if($invoices->isEmpty()): ?>
            <div class="alert alert-info"><?php echo e(__('messages.no_invoices') ?? 'You have no invoices.'); ?></div>
        <?php else: ?>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Lawyer</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($invoice->invoice_number); ?></td>
                                        <td><?php echo e($invoice->lawyer->user->name ?? 'Unknown'); ?></td>
                                        <td>$<?php echo e(number_format($invoice->amount, 2)); ?></td>
                                        <td><?php echo e($invoice->created_at->format('M d, Y')); ?></td>
                                        <td>
                                            <?php if($invoice->status === 'paid'): ?>
                                                <span class="badge bg-success">Paid</span>
                                            <?php elseif($invoice->status === 'cancelled'): ?>
                                                <span class="badge bg-secondary">Cancelled</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Unpaid</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('client.invoices.show', $invoice->id)); ?>"
                                                class="btn btn-sm btn-primary">View</a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Defence\LawLite\resources\views/client/invoices/index.blade.php ENDPATH**/ ?>