<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes for Flowbite template
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('example.index', ['title' => 'Dashboard']);
})->name('index');

Route::get('layouts/stacked', function () {
    return view('example.content.layouts.stacked', ['title' => 'Stacked Layout']);
})->name('layouts.stacked');

Route::get('layouts/sidebar', function () {
    return view('example.content.layouts.sidebar', ['title' => 'Sidebar Layout']);
})->name('layouts.sidebar');

// CRUD
Route::get('crud/products', function () {
    return view('example.content.crud.products', ['title' => 'Product Management']);
})->name('crud.products');

Route::get('crud/users', function () {
    return view('example.content.crud.users', ['title' => 'User Management']);
})->name('crud.users');

// Settings
Route::get('settings/', function () {
    return view('example.content.settings', ['title' => 'Settings']);
})->name('settings');

// Pages
Route::get('pages/pricing/', function () {
    return view('example.content.pages.pricing', ['title' => 'Pricing Plans']);
})->name('pages.pricing');

Route::get('pages/maintenance/', function () {
    return view('example.content.pages.maintenance', ['title' => 'Maintenance Mode']);
})->name('pages.maintenance');

Route::get('pages/404/', function () {
    return view('example.content.pages.404', ['title' => '404 - Page Not Found']);
})->name('pages.404');

Route::get('pages/500/', function () {
    return view('example.content.pages.500', ['title' => '500 - Server Error']);
})->name('pages.500');

// Authentication
Route::get('authentication/sign-in', function () {
    return view('example.content.authentication.sign-in', ['title' => 'Sign In']);
})->name('sign-in');

Route::get('authentication/sign-up', function () {
    return view('example.content.authentication.sign-up', ['title' => 'Sign Up']);
})->name('sign-up');

Route::get('authentication/forgot-password', function () {
    return view('example.content.authentication.forgot-password', ['title' => 'Forgot Password']);
})->name('forgot-password');

Route::get('authentication/reset-password', function () {
    return view('example.content.authentication.reset-password', ['title' => 'Reset Password']);
})->name('reset-password');

Route::get('authentication/profile-lock', function () {
    return view('example.content.authentication.profile-lock', ['title' => 'Profile Lock']);
})->name('profile-lock');

// Playground
Route::get('playground/stacked', function () {
    return view('example.content.playground.stacked', ['title' => 'Playground - Stacked Layout']);
})->name('playground.stacked');

Route::get('playground/sidebar', function () {
    return view('example.content.playground.sidebar', ['title' => 'Playground - Sidebar Layout']);
})->name('playground.sidebar');
