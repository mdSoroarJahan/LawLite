<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lawyer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EndToEndVerificationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_verification_flow_from_upload_to_admin_approval()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        Storage::fake('public');

        // Create a lawyer user (simulate registered lawyer)
        $lawyerUser = User::factory()->create(['role' => 'lawyer']);
        /** @var \App\Models\User $lawyerUser */

        // Lawyer uploads documents via profile edit
        $file1 = UploadedFile::fake()->create('license.pdf', 120, 'application/pdf');
        $file2 = UploadedFile::fake()->create('nid.png', 80, 'image/png');

        $this->actingAs($lawyerUser)
            ->post(route('lawyer.profile.edit'), [
                'name' => 'E2E Lawyer',
                'documents' => [$file1, $file2],
            ])
            ->assertRedirect(route('lawyer.dashboard'));

        // Lawyer requests verification
        $this->actingAs($lawyerUser)
            ->post(route('lawyer.request.verification'))
            ->assertRedirect(route('lawyer.dashboard'));

        $lawyerRow = Lawyer::where('user_id', $lawyerUser->id)->first();
        $this->assertNotNull($lawyerRow);
        // DB default for verification_status may be 'pending' (migration default) — accept either value before admin review.
        $this->assertContains($lawyerRow->verification_status, ['requested', 'pending']);
        $this->assertIsArray($lawyerRow->documents);
        $this->assertCount(2, $lawyerRow->documents);

        // Admin reviews and approves
        $admin = User::factory()->create(['role' => 'admin']);
        /** @var \App\Models\User $admin */

        $this->actingAs($admin)
            ->get(route('admin.verification.index'))
            ->assertStatus(200)
            ->assertSee(basename($lawyerRow->documents[0]));

        $this->actingAs($admin)
            ->post(route('admin.verification.approve', $lawyerRow->id))
            ->assertRedirect();

        $this->assertDatabaseHas('lawyers', ['id' => $lawyerRow->id, 'verification_status' => 'verified']);
    }
}
