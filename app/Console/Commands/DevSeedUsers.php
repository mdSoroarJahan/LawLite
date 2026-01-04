<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DevSeedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:seed-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create development seed users (admin, lawyer, user) idempotently';

    public function handle(): int
    {
        $map = [
            'admin' => 'admin@example.com',
            'lawyer' => 'lawyer@example.com',
            'user' => 'user@example.com',
        ];

        foreach ($map as $role => $email) {
            $user = User::where('email', $email)->first();
            /** @var User|null $user */
            if (! $user) {
                $user = User::create([
                    'name' => ucfirst($role) . ' Tester',
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'role' => $role,
                ]);
                $this->info("Created {$email} as {$role}");
            } else {
                $this->info("Exists: {$email} (role: " . ($user->role ?? '(none)') . ")");
                if (! ($user->role ?? null)) {
                    $user->role = $role;
                    $user->save();
                    $this->info(" -> Set role to {$role}");
                }
            }
        }

        $this->info('Dev seed users ensured. Password for each user is "password" (local only).');
        return 0;
    }
}
