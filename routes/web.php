<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('hero');
});

Route::get('/home', function () {
    return view('hero');
})->name('home');