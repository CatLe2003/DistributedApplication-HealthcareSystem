<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard.homepage');
});

Route::get('/home', function () {
    return view('dashboard.homepage');
});

Route::get('/login', function () {
    return view('auth.login');
});
