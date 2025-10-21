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

// Notification endpoints (AJAX)
Route::middleware('auth')->get('/notifications', [NotificationsController::class, 'index']);
Route::middleware('auth')->post('/notifications/mark-read', [NotificationsController::class, 'markRead']);

// Chat endpoints
Route::middleware('auth')->post('/chat/send', [ChatController::class, 'send']);
Route::middleware('auth')->get('/chat/history/{withUserId}', [ChatController::class, 'history']);

// Appointment booking
Route::middleware('auth')->post('/appointments/book', [AppointmentController::class, 'book']);
