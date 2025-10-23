<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            LawyerSeeder::class,
            ArticleSeeder::class,
            \Database\Seeders\DevUserSeeder::class,
        ]);
    }
}
