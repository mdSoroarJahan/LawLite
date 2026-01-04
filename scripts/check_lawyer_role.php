<?php

use App\Models\User;

$email = 'lawyer@example.com'; // Assuming this is the email being used, or I'll list all lawyers.
$users = User::where('role', 'lawyer')->get();

foreach ($users as $user) {
    echo "User: {$user->email}, Role: {$user->role}\n";
}
