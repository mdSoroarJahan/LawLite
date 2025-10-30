<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$emails = ['admin@example.com', 'lawyer@example.com', 'user@example.com', 'admin@lawlite.test'];
$users = App\Models\User::whereIn('email', $emails)->get();
/** @var \Illuminate\Database\Eloquent\Collection<int, App\Models\User> $users */
foreach ($users as $u) {
    echo $u->email . " => " . ($u->role ?? '(no role)') . PHP_EOL;
}
if (count($users) === 0) echo "no users found\n";
