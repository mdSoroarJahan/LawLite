<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lawyer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LawyerProfileUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_lawyer_can_upload_documents()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        Storage::fake('public');

        $user = User::factory()->create(['role' => 'lawyer']);
        /** @var \App\Models\User $user */

        $file1 = UploadedFile::fake()->create('license.pdf', 100, 'application/pdf');
        $file2 = UploadedFile::fake()->create('nid.jpg', 150, 'image/jpeg');

        $response = $this->actingAs($user)
            ->post(route('lawyer.profile.edit'), [
                'name' => 'Lawyer One',
                'documents' => [$file1, $file2],
            ]);

        $response->assertRedirect(route('lawyer.dashboard'));

        $lawyer = Lawyer::where('user_id', $user->id)->first();
        $this->assertNotNull($lawyer);
        $this->assertIsArray($lawyer->documents);
        $this->assertCount(2, $lawyer->documents);

        // Ensure files were stored on the public disk
        $publicDisk = Storage::disk('public');
        foreach ($lawyer->documents as $path) {
            /** @var \Illuminate\Filesystem\FilesystemAdapter $publicDisk */
            $this->assertTrue($publicDisk->exists($path), "File {$path} should exist on public disk");
        }
    }

    public function test_admin_sees_uploaded_documents_in_verification_list()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        /** @var \App\Models\User $admin */
        $user = User::factory()->create(['role' => 'lawyer']);
        /** @var \App\Models\User $user */

        Storage::fake('public');
        // Put a fake file so Storage::url will resolve
        Storage::disk('public')->put('lawyer_documents/sample.pdf', 'contents');

        $lawyer = Lawyer::factory()->create([
            'user_id' => $user->id,
            'verification_status' => 'requested',
            'documents' => ['lawyer_documents/sample.pdf'],
        ]);

        $this->actingAs($admin)
            ->get(route('admin.verification.index'))
            ->assertStatus(200)
            ->assertSee('lawyer_documents/sample.pdf');
    }
}
