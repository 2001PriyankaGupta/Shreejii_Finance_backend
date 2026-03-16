<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $stats = [
        'users' => \App\Models\User::count(),
        'loans' => \App\Models\Loan::count(),
        'leads' => \App\Models\Lead::count(),
        'tasks' => \App\Models\Task::count(),
    ];
    return view('dashboard', compact('stats'));
})->middleware(['auth', 'verified', 'prevent-back-history'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
