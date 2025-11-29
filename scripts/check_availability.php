<?php

use App\Models\Lawyer;
use App\Models\LawyerAvailability;

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$lawyers = Lawyer::all();
echo "Total Lawyers: " . $lawyers->count() . "\n";

foreach ($lawyers as $lawyer) {
    echo "Lawyer ID: {$lawyer->id} - Name: " . ($lawyer->user->name ?? 'Unknown') . "\n";
    $availabilities = $lawyer->availabilities;
    echo "  Availabilities: " . $availabilities->count() . "\n";
    foreach ($availabilities as $avail) {
        echo "    - {$avail->day_of_week}: {$avail->start_time} to {$avail->end_time}\n";
    }
}
