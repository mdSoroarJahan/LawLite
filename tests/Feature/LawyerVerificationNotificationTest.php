<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Lawyer;
use App\Notifications\LawyerVerificationRequested;

class LawyerVerificationNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admins_are_notified_when_lawyer_requests_verification()
    {
        Notification::fake();

        // create an admin and a lawyer user
        $admin = User::factory()->create(['role' => 'admin']);
        $lawyerUser = User::factory()->create(['role' => 'lawyer']);
        /** @var \App\Models\User $lawyerUser */

        // Ensure lawyer has a related lawyer record
        $lawyer = Lawyer::factory()->create(['user_id' => $lawyerUser->id]);

        // Disable CSRF middleware for this test environment
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $this->actingAs($lawyerUser)
            ->post(route('lawyer.request.verification'))
            ->assertRedirect();

        Notification::assertSentTo(
            [$admin],
            LawyerVerificationRequested::class,
            function ($notification, $channels) use ($lawyer) {
                return $notification->getLawyer()->id === $lawyer->id;
            }
        );
    }
}
