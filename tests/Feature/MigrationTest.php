<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

class MigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_table_exists(): void
    {
        $this->assertTrue(Schema::hasTable('users'), 'Users table does not exist');
    }
}
