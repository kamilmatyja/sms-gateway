<?php

use App\Http\Controllers\SmsController;

Route::get('/sms', [SmsController::class, 'index']);
Route::post('/sms', [SmsController::class, 'send']);
