<?php

// Fix appointments that have payment_status='paid' but status='pending'
// Run with: php scripts/fix_paid_appointments.php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Appointment;

// Find all appointments that have been paid but still pending
$appointments = Appointment::where('payment_status', 'paid')
    ->where('status', 'pending')
    ->get();

echo "Found " . $appointments->count() . " appointments to fix.\n";

foreach ($appointments as $appointment) {
    echo "Fixing appointment #{$appointment->id} for user {$appointment->user_id}...\n";
    $appointment->update(['status' => 'confirmed']);
}

echo "Done! All paid appointments are now confirmed.\n";
