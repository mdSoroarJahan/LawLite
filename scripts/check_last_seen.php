<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$users = User::all();

foreach ($users as $user) {
    echo "User: {$user->email}, Last Seen: " . ($user->last_seen_at ?? 'Never') . "\n";
    echo "Is Online (Cache): " . ($user->isOnline() ? 'Yes' : 'No') . "\n";
    echo "--------------------------------\n";
}
