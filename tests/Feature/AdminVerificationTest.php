<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lawyer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class AdminVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_approve_verification()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        \Illuminate\Support\Facades\Storage::fake('public');
        // create a sample stored file so the admin page can link to it
        Storage::disk('public')->put('lawyer_documents/sample.pdf', 'dummy');

        $admin = User::factory()->create(['role' => 'admin']);
        /** @var \App\Models\User $admin */
        $user = User::factory()->create(['role' => 'lawyer']);
        /** @var \App\Models\User $user */
        $lawyer = Lawyer::factory()->create([
            'user_id' => $user->id,
            'verification_status' => 'requested',
            'documents' => ['lawyer_documents/sample.pdf'],
        ]);

        // Admin should be able to see document link on the verification index
        $this->actingAs($admin)
            ->get(route('admin.verification.index'))
            ->assertStatus(200)
            ->assertSee('sample.pdf');

        // Approve action
        $this->actingAs($admin)
            ->post(route('admin.verification.approve', $lawyer->id))
            ->assertRedirect();

        $this->assertDatabaseHas('lawyers', ['id' => $lawyer->id, 'verification_status' => 'verified']);
    }

    public function test_non_admin_cannot_access_verification_page()
    {
        $user = User::factory()->create(['role' => 'user']);
        /** @var \App\Models\User $user */

        $this->actingAs($user)
            ->get(route('admin.verification.index'))
            ->assertStatus(403);
    }
}
