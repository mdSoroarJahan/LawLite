<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$map = [
    'admin' => 'admin@example.com',
    'lawyer' => 'lawyer@example.com',
    'user' => 'user@example.com',
];

foreach ($map as $role => $email) {
    $user = User::where('email', $email)->first();
    /** @var \App\Models\User|null $user */
    if (! $user) {
        $user = User::create([
            'name' => ucfirst($role) . ' Tester',
            'email' => $email,
            'password' => Hash::make('password'),
            'role' => $role,
        ]);
        echo "Created: {$email} as role {$role}\n";
    } else {
        echo "Exists: {$email} (role: " . ($user->role ?? '(no role)') . ")\n";
        if (! ($user->role ?? null)) {
            $user->role = $role;
            $user->save();
            echo " -> Set role to {$role}\n";
        }
    }
}
