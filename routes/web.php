<?php

use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReplyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('discussion', DiscussionController::class);
Route::resource('discussion/{discussion}/replies', ReplyController::class);
Route::post('discussion/{discussion}/replies/{reply}/mark-as-best', [DiscussionController::class, 'reply'])->name('discussions.best-reply');
Route::get('/notifications/{id}/read', [NotificationController::class, 'readNotification'])
    ->middleware('auth')
    ->name('notifications.read');
require __DIR__.'/auth.php';
