<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('sms.index');
});

Route::get('/api/docs', function () {
    return redirect('/api/documentation');
});
