<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientsModuleController;
use App\Http\Controllers\AdminModuleController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth:admin'])->group(function () {
    Route::get('/adminDashboard', [AdminModuleController::class, 'adminDashboard'])->name('adminDashboard');
});
Route::middleware(['guest:admin'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('show.register');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('show.login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/home', [PagesController::class, 'Home'])->name('home');
    Route::get('/listings', [PagesController::class, 'Listings'])->name('listings');
    Route::get('/services', [PagesController::class, 'Services'])->name('services');
    Route::get('/about', [PagesController::class, 'About'])->name('about');
});

Route::middleware(['auth:client'])->group(function () {
    Route::get('/clientsProfile', [ClientsModuleController::class, 'clientsProfile'])->name('clientsProfile');
    Route::get('/listings', [ClientsModuleController::class, 'listings'])->name('listings');
    Route::get('/favorites', [ClientsModuleController::class, 'favorites'])->name('favorites');
    Route::get('/maps', [ClientsModuleController::class, 'maps'])->name('maps');
    Route::get('/messages', [ClientsModuleController::class, 'messages'])->name('messages');
    Route::get('/myProperty', [ClientsModuleController::class, 'myProperty'])->name('myProperty');
    
});

Route::middleware(['guest:client'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('show.register');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('show.login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/home', [PagesController::class, 'Home'])->name('home');
    Route::get('/listings', [PagesController::class, 'Listings'])->name('listings');
    Route::get('/services', [PagesController::class, 'Services'])->name('services');
    Route::get('/about', [PagesController::class, 'About'])->name('about');

});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
