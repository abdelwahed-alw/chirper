<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Models\Comment;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $comments = Comment::with('user')->latest()->get();
    return view('welcome', compact('comments'));
});

Route::middleware('auth')->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
});

Route::get('/dashboard', function () {
    $comments = Comment::with('user')->latest()->get();
    return view('dashboard', compact('comments'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
