<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Total Messages: " . App\Models\Message::count() . "\n";
echo "Total Users: " . App\Models\User::count() . "\n";

$messages = App\Models\Message::all();
foreach($messages as $m) {
    echo "Msg: " . $m->sender_id . " -> " . $m->receiver_id . "\n";
}
