<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AiController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'lawyer') {
            return redirect()->route('lawyer.dashboard');
        }
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
    }
    return view('welcome');
});

Route::post('/ai/question', [AiController::class, 'ask'])->name('ai.ask');
Route::post('/ai/summarize', [AiController::class, 'summarize'])->name('ai.summarize');

// Static Pages
Route::get('/about', [\App\Http\Controllers\PageController::class, 'about'])->name('about');
Route::get('/contact', [\App\Http\Controllers\PageController::class, 'contact'])->name('contact');
Route::get('/privacy', [\App\Http\Controllers\PageController::class, 'privacy'])->name('privacy');

// Public list of lawyers
Route::get('/lawyers', [\App\Http\Controllers\LawyerController::class, 'index'])->name('lawyers.index');
Route::get('/lawyers/{id}', [\App\Http\Controllers\LawyerController::class, 'show'])->name('lawyers.show');
// Get available slots
Route::get('/lawyers/{id}/slots', [AppointmentController::class, 'getSlots'])->name('lawyers.slots');

// Articles
Route::get('/articles', [\App\Http\Controllers\ArticlesController::class, 'index'])->name('articles.index');
Route::get('/articles/{id}', [\App\Http\Controllers\ArticlesController::class, 'show'])->name('articles.show');

// Public appointments listing (placeholder)
Route::get('/appointments', [\App\Http\Controllers\AppointmentController::class, 'index'])->name('appointments.index');

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

// Dev helper: create/find test user and login (only in local env)
Route::get('/_dev/login-as', function () {
    if (env('APP_ENV') !== 'local') {
        abort(404);
    }

    $email = 'test@example.com';
    $user = \App\Models\User::where('email', $email)->first();
    if (! $user) {
        $user = \App\Models\User::create([
            'name' => 'Dev Tester',
            'email' => $email,
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);
    }

    \Illuminate\Support\Facades\Auth::login($user);

    return redirect('/')->with('status', 'Logged in as ' . $user->email . ' (dev)');
});

// Dev quick-switch by role
Route::get('/_dev/login-as/{role}', function ($role) {
    if (env('APP_ENV') !== 'local') {
        abort(404);
    }

    $map = [
        'admin' => 'admin@example.com',
        'lawyer' => 'lawyer@example.com',
        'user' => 'user@example.com',
    ];

    if (! isset($map[$role])) abort(404);

    $user = \App\Models\User::where('email', $map[$role])->first();
    if (! $user) {
        // create if missing
        $user = \App\Models\User::create([
            'name' => ucfirst($role) . ' Tester',
            'email' => $map[$role],
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);
    }

    \Illuminate\Support\Facades\Auth::login($user);
    return redirect('/')->with('status', 'Logged in as ' . $user->email);
});
Route::get('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');
// Auth form submission
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'store'])->name('register.post');

// Lawyer dashboard (post-login landing for lawyers)
Route::middleware(['auth', 'role:lawyer'])->get('/lawyer/dashboard', [\App\Http\Controllers\LawyerDashboardController::class, 'dashboard'])->name('lawyer.dashboard');
Route::middleware(['auth', 'role:lawyer'])->get('/lawyer/appointments', [\App\Http\Controllers\LawyerDashboardController::class, 'appointments'])->name('lawyer.appointments');
Route::middleware(['auth', 'role:lawyer'])->post('/lawyer/appointments/{id}/accept', [\App\Http\Controllers\LawyerDashboardController::class, 'acceptAppointment'])->name('lawyer.appointments.accept');
Route::middleware(['auth', 'role:lawyer'])->post('/lawyer/appointments/{id}/reject', [\App\Http\Controllers\LawyerDashboardController::class, 'rejectAppointment'])->name('lawyer.appointments.reject');
Route::middleware(['auth', 'role:lawyer'])->match(['get', 'post'], '/lawyer/profile/edit', [\App\Http\Controllers\LawyerDashboardController::class, 'editProfile'])->name('lawyer.profile.edit');
Route::middleware(['auth', 'role:lawyer'])->post('/lawyer/request-verification', [\App\Http\Controllers\LawyerDashboardController::class, 'requestVerification'])->name('lawyer.request.verification');

// Lawyer case management
Route::middleware(['auth', 'role:lawyer'])->resource('lawyer/cases', \App\Http\Controllers\Lawyer\CaseController::class, ['as' => 'lawyer']);
Route::middleware(['auth', 'role:lawyer'])->post('/lawyer/cases/{id}/documents', [\App\Http\Controllers\Lawyer\CaseController::class, 'uploadDocument'])->name('lawyer.cases.documents.store');
Route::middleware(['auth', 'role:lawyer'])->post('/lawyer/cases/{id}/tasks', [\App\Http\Controllers\Lawyer\CaseController::class, 'storeTask'])->name('lawyer.cases.tasks.store');
Route::middleware(['auth', 'role:lawyer'])->put('/lawyer/cases/{id}/tasks/{taskId}', [\App\Http\Controllers\Lawyer\CaseController::class, 'updateTask'])->name('lawyer.cases.tasks.update');
Route::middleware(['auth', 'role:lawyer'])->delete('/lawyer/cases/{id}/tasks/{taskId}', [\App\Http\Controllers\Lawyer\CaseController::class, 'destroyTask'])->name('lawyer.cases.tasks.destroy');

// Lawyer Invoices
Route::middleware(['auth', 'role:lawyer'])->group(function () {
    Route::get('/lawyer/invoices', [\App\Http\Controllers\Lawyer\InvoiceController::class, 'index'])->name('lawyer.invoices.index');
    Route::get('/lawyer/invoices/create', [\App\Http\Controllers\Lawyer\InvoiceController::class, 'create'])->name('lawyer.invoices.create');
    Route::post('/lawyer/invoices', [\App\Http\Controllers\Lawyer\InvoiceController::class, 'store'])->name('lawyer.invoices.store');
    Route::get('/lawyer/invoices/{id}', [\App\Http\Controllers\Lawyer\InvoiceController::class, 'show'])->name('lawyer.invoices.show');
    Route::post('/lawyer/invoices/{id}/pay', [\App\Http\Controllers\Lawyer\InvoiceController::class, 'markAsPaid'])->name('lawyer.invoices.pay');
});

// Lawyer availability management
Route::middleware(['auth', 'role:lawyer'])->group(function () {
    Route::get('/lawyer/availability', [\App\Http\Controllers\LawyerAvailabilityController::class, 'index'])->name('lawyer.availability.index');
    Route::post('/lawyer/availability', [\App\Http\Controllers\LawyerAvailabilityController::class, 'update'])->name('lawyer.availability.update');
});

// Admin dashboard and management routes (protected)
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{id}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');

    // Verification review
    Route::get('/admin/verification', [\App\Http\Controllers\Admin\VerificationController::class, 'index'])->name('admin.verification.index');
    Route::get('/admin/verification/{id}', [\App\Http\Controllers\Admin\VerificationController::class, 'show'])->name('admin.verification.show');
    Route::post('/admin/verification/{id}/approve', [\App\Http\Controllers\Admin\VerificationController::class, 'approve'])->name('admin.verification.approve');
    Route::post('/admin/verification/{id}/reject', [\App\Http\Controllers\Admin\VerificationController::class, 'reject'])->name('admin.verification.reject');
    Route::post('/admin/verification/{id}/request-info', [\App\Http\Controllers\Admin\VerificationController::class, 'requestInfo'])->name('admin.verification.request_info');
});

// Local debug: show session id and CSRF token
Route::get('/_debug/session', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'session_id' => $request->session()->getId(),
        'csrf_token' => $request->session()->get('_token'),
        'cookies' => $request->cookies->all(),
    ]);
});

// Notifications
Route::middleware('auth')->get('/notifications', [NotificationsController::class, 'index'])->name('notifications.index');
Route::middleware('auth')->get('/notifications/json', [NotificationsController::class, 'getJson'])->name('notifications.json');
Route::middleware('auth')->post('/notifications/{id}/mark-read', [NotificationsController::class, 'markRead'])->name('notifications.mark-read');
Route::middleware('auth')->post('/notifications/mark-all-read', [NotificationsController::class, 'markAllRead'])->name('notifications.mark-all-read');

// User profile
Route::middleware('auth')->get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
Route::middleware('auth')->put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
Route::middleware('auth')->put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');

// Chat endpoints
Route::middleware('auth')->get('/messages', [ChatController::class, 'inbox'])->name('messages.inbox');
Route::middleware('auth')->post('/chat/send', [ChatController::class, 'send']);
Route::middleware('auth')->post('/chat/signal', [ChatController::class, 'signal']);
Route::middleware('auth')->get('/chat/history/{withUserId}', [ChatController::class, 'history']);

// Appointment booking
Route::middleware('auth')->post('/appointments/book', [AppointmentController::class, 'book']);

// User Case Portal
Route::middleware('auth')->group(function () {
    Route::get('/my-cases', [\App\Http\Controllers\UserCaseController::class, 'index'])->name('user.cases.index');
    Route::get('/my-cases/{id}', [\App\Http\Controllers\UserCaseController::class, 'show'])->name('user.cases.show');

    // Client Invoices
    Route::get('/my-invoices', [\App\Http\Controllers\Client\InvoiceController::class, 'index'])->name('client.invoices.index');
    Route::get('/my-invoices/{id}', [\App\Http\Controllers\Client\InvoiceController::class, 'show'])->name('client.invoices.show');
    Route::get('/my-invoices/{id}/checkout', [\App\Http\Controllers\Client\InvoiceController::class, 'checkout'])->name('client.invoices.checkout');
    Route::post('/my-invoices/{id}/pay', [\App\Http\Controllers\Client\InvoiceController::class, 'processPayment'])->name('client.invoices.pay');
});
