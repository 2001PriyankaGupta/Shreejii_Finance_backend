<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\MobileController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\PartnerAuthController;

use App\Http\Controllers\Api\AdminPartnerController;
use App\Http\Controllers\Api\InquiryController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\WalletController;

Route::get('test', function() {
    return response()->json(['message' => 'API is working']);
});

// Admin Testing Route (Move to middleware eventually)
Route::post('/admin/partner/status', [AdminPartnerController::class, 'updateStatus']);


// Public Routes
Route::prefix('auth')->group(function () {
    Route::post('/login', [MobileController::class, 'login']);
    Route::post('/register', [MobileController::class, 'register']);
    Route::post('/verify-otp', [MobileController::class, 'verifyOtp']);
    Route::post('/partner/register', [PartnerAuthController::class, 'register']);
});

Route::get('/settings', [MobileController::class, 'getSettings']);
Route::post('/inquiry', [InquiryController::class, 'store']);
Route::get('/wallet/statement', [WalletController::class, 'downloadStatement']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/profile', [MobileController::class, 'getProfile']);
        Route::post('/profile', [MobileController::class, 'createProfile']);
        Route::post('/updateProfile', [MobileController::class, 'updateProfile']);
        Route::post('/profile/image', [MobileController::class, 'updateProfileImage']);
        Route::post('/documents/upload', [MobileController::class, 'uploadDocument']);
        Route::get('/notifications', [MobileController::class, 'getNotifications']);
        Route::get('/messages', [MessageController::class, 'getMessages']);
        Route::post('/messages', [MessageController::class, 'sendMessage']);
    });

    Route::post('/partner/profile', [PartnerAuthController::class, 'createProfile']);
    Route::post('/partner/reset', [PartnerAuthController::class, 'resetRegistration']);

    Route::prefix('loans')->group(function () {
        Route::get('/', [MobileController::class, 'getMyLoans']);
        Route::post('/apply', [MobileController::class, 'applyLoan']);
        Route::post('/elite/apply', [MobileController::class, 'submitEliteApplication']);
        Route::post('/elite/send-otp', [MobileController::class, 'sendEliteOtp']);
        Route::get('/elite', [MobileController::class, 'getEliteApplications']);
    });

    Route::prefix('leads')->group(function () {
        Route::get('/', [LeadController::class, 'index']);
        Route::post('/create', [LeadController::class, 'store']);
        Route::get('/{lead}', [LeadController::class, 'show']);
        Route::put('/{lead}', [LeadController::class, 'update']);
        Route::delete('/{lead}', [LeadController::class, 'destroy']);
    });

    Route::get('/tasks', [MobileController::class, 'getTasks']);
    
    Route::prefix('wallet')->group(function () {
        Route::get('/', [WalletController::class, 'index']);
        Route::post('/withdraw', [WalletController::class, 'withdraw']);
    });
});
