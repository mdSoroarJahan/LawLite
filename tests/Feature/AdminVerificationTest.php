<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lawyer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_approve_verification()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'lawyer']);
        $lawyer = Lawyer::factory()->create(['user_id' => $user->id, 'verification_status' => 'requested']);

        $this->actingAs($admin)
            ->post(route('admin.verification.approve', $lawyer->id))
            ->assertRedirect();

        $this->assertDatabaseHas('lawyers', ['id' => $lawyer->id, 'verification_status' => 'verified']);
    }

    public function test_non_admin_cannot_access_verification_page()
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)
            ->get(route('admin.verification.index'))
            ->assertStatus(403);
    }
}
