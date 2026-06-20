<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/rental', function () {
    return view('rental');
});

Route::get('/service', function () {
    return view('service');
});

Route::get('/service/cuci-alat', function () {
    return view('cuci-alat');
});

Route::get('/service/open-trip', function () {
    return view('open-trip');
});

Route::get('/konfirmasi-pendaftaran', function () {
    return view('konfirmasi-pendaftaran');
});

Route::get('/konfirmasi-booking-guide', function () {
    return view('konfirmasi-booking-guide');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});