<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$users = User::where('role', 'lawyer')->get();

if ($users->isEmpty()) {
    echo "No users with role 'lawyer' found.\n";
} else {
    foreach ($users as $user) {
        echo "User: {$user->email}, Role: {$user->role}\n";
    }
}
