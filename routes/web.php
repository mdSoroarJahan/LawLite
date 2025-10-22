<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AiController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AppointmentController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/ai/question', [AiController::class, 'ask'])->name('ai.ask');
Route::post('/ai/summarize', [AiController::class, 'summarize'])->name('ai.summarize');

// Public list of lawyers
Route::get('/lawyers', [\App\Http\Controllers\LawyerController::class, 'index'])->name('lawyers.index');
Route::get('/lawyers/{id}', [\App\Http\Controllers\LawyerController::class, 'show'])->name('lawyers.show');

// Articles
Route::get('/articles', [\App\Http\Controllers\ArticlesController::class, 'index'])->name('articles.index');
Route::get('/articles/{id}', [\App\Http\Controllers\ArticlesController::class, 'show'])->name('articles.show');

// Public appointments listing (placeholder)
Route::get('/appointments', function () {
    return view('appointments.index');
})->name('appointments.index');

// Auth pages (placeholders)
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
// Development helper: render login with visible token for debugging CSRF/session
Route::get('/login/debug', function (\Illuminate\Http\Request $request) {
    $token = $request->session()->token();
    return "<html><body><h3>Debug login</h3><p>session_id: " . $request->session()->getId() . "</p><p>csrf token: " . e($token) . "</p>" .
        "<form method=\"POST\" action=\"/_debug/echo\">" . csrf_field() . "<div><input name=\"email\"/></div><div><input name=\"password\"/></div><button>Submit</button></form></body></html>";
});

// Development POST echo endpoint: returns submitted token and server token for debugging
Route::post('/_debug/echo', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'submitted' => $request->all(),
        'submitted__token' => $request->input('_token'),
        'server_session_id' => $request->session()->getId(),
        'server_session__token' => $request->session()->get('_token'),
        'cookies' => $request->cookies->all(),
    ]);
});
Route::get('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');
// Auth form submission
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'store'])->name('register.post');

// Admin dashboard placeholder (protect in future)
Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');

// Local debug: show session id and CSRF token
Route::get('/_debug/session', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'session_id' => $request->session()->getId(),
        'csrf_token' => $request->session()->get('_token'),
        'cookies' => $request->cookies->all(),
    ]);
});

// Notification endpoints (AJAX)
Route::middleware('auth')->get('/notifications', [NotificationsController::class, 'index']);
Route::middleware('auth')->post('/notifications/mark-read', [NotificationsController::class, 'markRead']);

// Chat endpoints
Route::middleware('auth')->post('/chat/send', [ChatController::class, 'send']);
Route::middleware('auth')->get('/chat/history/{withUserId}', [ChatController::class, 'history']);

// Appointment booking
Route::middleware('auth')->post('/appointments/book', [AppointmentController::class, 'book']);
