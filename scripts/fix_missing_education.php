<?php

use App\Models\Lawyer;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Updating lawyer education data...\n";

$lawyers = Lawyer::all();
$universities = ['University of Dhaka', 'North South University', 'BRAC University', 'Chittagong University', 'Rajshahi University', 'London College of Legal Studies'];
$degrees = ['LLB (Honours)', 'LLM', 'Bar at Law', 'Barrister-at-Law'];

foreach ($lawyers as $lawyer) {
    // Always update for now to ensure data is visible
    $education = [
        $degrees[array_rand($degrees)] . ' from ' . $universities[array_rand($universities)]
    ];

    // Add a second degree sometimes
    if (rand(0, 1)) {
        $education[] = $degrees[array_rand($degrees)] . ' from ' . $universities[array_rand($universities)];
    }

    $lawyer->education = $education;

    // Also fix city if missing
    if (empty($lawyer->city) || $lawyer->city === 'Unknown') {
        $lawyer->city = 'Dhaka';
    }

    $lawyer->save();
    echo "Updated Lawyer ID: {$lawyer->id} with education: " . $education[0] . "\n";
}

echo "Update complete.\n";
