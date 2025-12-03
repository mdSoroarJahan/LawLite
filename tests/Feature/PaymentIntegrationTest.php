<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lawyer;
use App\Models\LawyerAvailability;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class PaymentIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_initiates_sslcommerz_payment()
    {
        // Disable CSRF for this test
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        // 1. Setup User
        $user = User::where('role', 'client')->first();
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Test Client',
                'email' => 'testclient_' . uniqid() . '@example.com',
                'role' => 'client',
                'password' => bcrypt('password')
            ]);
        }

        // 2. Setup Lawyer
        $lawyer = Lawyer::first();
        if (!$lawyer) {
            // Create a lawyer user first
            $lawyerUser = User::factory()->create([
                'name' => 'Test Lawyer',
                'email' => 'testlawyer_' . uniqid() . '@example.com',
                'role' => 'lawyer',
                'password' => bcrypt('password')
            ]);
            $lawyer = Lawyer::create([
                'user_id' => $lawyerUser->id,
                'hourly_rate' => 1000,
                'bio' => 'Test Bio',
                'specialization' => 'General'
            ]);
        }

        // 3. Ensure Availability for "Tomorrow" at 10:00
        $tomorrow = Carbon::tomorrow();
        $dayOfWeek = strtolower($tomorrow->format('l'));

        // Check if availability exists, if not create it
        $exists = LawyerAvailability::where('lawyer_id', $lawyer->id)
            ->where('day_of_week', $dayOfWeek)
            ->exists();

        if (!$exists) {
            LawyerAvailability::create([
                'lawyer_id' => $lawyer->id,
                'day_of_week' => $dayOfWeek,
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
                'is_active' => true
            ]);
        }

        // 4. Make the Booking Request
        $response = $this->actingAs($user)->postJson('/appointments/book', [
            'lawyer_id' => $lawyer->id,
            'date' => $tomorrow->format('Y-m-d'),
            'time' => '10:00',
            'payment_method' => 'sslcommerz',
            'notes' => 'Integration Test Booking',
        ]);

        // 5. Debug Output if failed
        if ($response->status() !== 200) {
            dump($response->json());
        }

        // 6. Assertions for Booking Response
        $response->assertStatus(200);
        $response->assertJsonStructure(['redirect_url']);

        $checkoutUrl = $response->json('redirect_url');
        $this->assertStringContainsString('/payment/checkout/', $checkoutUrl);

        // 7. Simulate the "Pay Now" click (POST to payment.process)
        // Extract appointment ID from URL or response
        $appointmentId = basename($checkoutUrl);

        $processResponse = $this->actingAs($user)->post('/payment/process/' . $appointmentId);

        // 8. Assert Redirect to SSLCommerz
        $processResponse->assertStatus(302); // Redirect
        $targetUrl = $processResponse->headers->get('Location');

        $this->assertStringContainsString('sslcommerz.com', $targetUrl);

        echo "\nSuccess! Final Redirect URL: " . $targetUrl . "\n";
    }
}
