<?php

use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Load the app
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Simulate a user
$user = User::first();
if (!$user) {
    echo "No users found.\n";
    exit(1);
}
Auth::login($user);
echo "Logged in as User ID: " . $user->id . "\n";

// Find another user to chat with
$otherUser = User::where('id', '!=', $user->id)->first();
if (!$otherUser) {
    echo "No other users found.\n";
    exit(1);
}
echo "Chatting with User ID: " . $otherUser->id . "\n";

// Create request
$request = Request::create('/chat/history/' . $otherUser->id, 'GET');
$request->setUserResolver(function () use ($user) {
    return $user;
});

// Call controller
$controller = new ChatController();
try {
    $response = $controller->history($request, $otherUser->id);
    echo "Response Status: " . $response->status() . "\n";
    echo "Response Content: " . $response->content() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
