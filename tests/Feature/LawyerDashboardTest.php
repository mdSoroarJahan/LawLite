<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lawyer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LawyerDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_lawyer_can_request_verification()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        // Create a user with role lawyer
        $user = User::factory()->create(['role' => 'lawyer']);
        /** @var \App\Models\User $user */
        // Ensure no lawyer row exists yet
        $this->assertDatabaseMissing('lawyers', ['user_id' => $user->id]);

        $this->actingAs($user)
            ->post(route('lawyer.request.verification'))
            ->assertRedirect(route('lawyer.dashboard'));

        $this->assertDatabaseHas('lawyers', ['user_id' => $user->id, 'verification_status' => 'requested']);
    }

    public function test_non_lawyer_cannot_request_verification()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $user = User::factory()->create(['role' => 'user']);
        /** @var \App\Models\User $user */

        $this->actingAs($user)
            ->post(route('lawyer.request.verification'))
            ->assertStatus(403);
    }
}
