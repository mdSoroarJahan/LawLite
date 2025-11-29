<?php

use App\Models\Lawyer;
use App\Models\LawyerAvailability;

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Seeding lawyer availability...\n";

$lawyers = Lawyer::all();
$days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

foreach ($lawyers as $lawyer) {
    echo "Setting availability for Lawyer ID: {$lawyer->id}\n";

    // Clear existing
    $lawyer->availabilities()->delete();

    foreach ($days as $day) {
        LawyerAvailability::create([
            'lawyer_id' => $lawyer->id,
            'day_of_week' => $day,
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'is_active' => true,
        ]);
    }
}

echo "Availability seeding complete.\n";
