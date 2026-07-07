<?php

use App\Http\Controllers\Api\V1\SendMessageController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::post('send/message', [SendMessageController::class, 'message']);
    Route::post('send/contact', [SendMessageController::class, 'contact']);
    Route::post('send/link', [SendMessageController::class, 'link']);
    Route::post('send/location', [SendMessageController::class, 'location']);
    Route::post('send/poll', [SendMessageController::class, 'poll']);
    Route::post('send/presence', [SendMessageController::class, 'presence']);
    Route::post('send/chat-presence', [SendMessageController::class, 'chatPresence']);
});
