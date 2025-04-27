<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientsModuleController;
use App\Http\Controllers\AdminModuleController;
use App\Http\Controllers\AgentModuleController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\GuestAlertAdminMW;
use App\Http\Middleware\GuestAlertClientMW;

Route::get('/', function () {
    return view('welcome');
});

// Public Pages
Route::get('/', [PagesController::class, 'Home'])->name('home');
Route::get('/listings', [PagesController::class, 'Listings'])->name('listings');
Route::get('/services', [PagesController::class, 'Services'])->name('services');
Route::get('/about', [PagesController::class, 'About'])->name('about');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('show.login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('show.register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Admin views
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/adminDashboard', [AdminModuleController::class, 'adminDashboard'])->name('adminDashboard');
    Route::get('/adminAgents', [AdminModuleController::class, 'adminAgents'])->name('adminAgents');
});


Route::middleware(['guestwithalert:admin', 'guestwithalert:client'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('show.register');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('show.login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/', [PagesController::class, 'Home'])->name('home');
    Route::get('/listings', [PagesController::class, 'Listings'])->name('listings');
    Route::get('/services', [PagesController::class, 'Services'])->name('services');
    Route::get('/about', [PagesController::class, 'About'])->name('about');
});


// Agent views
Route::middleware(['auth:agent'])->group(function () {
    Route::get('/agentDashboard', [AgentModuleController::class, 'agentDashboard'])->name('agentDashboard');
    // add more agent pages here
});

// Client views
Route::middleware(['auth:client'])->group(function () {
    Route::get('/clientsProfile', [ClientsModuleController::class, 'clientsProfile'])->name('clientsProfile');
    Route::get('/clientsListings', [ClientsModuleController::class, 'clientsListings'])->name('clientsListings');
    Route::get('/favorites', [ClientsModuleController::class, 'favorites'])->name('favorites');
    Route::get('/maps', [ClientsModuleController::class, 'maps'])->name('maps');
    Route::get('/messages', [ClientsModuleController::class, 'messages'])->name('messages');
    Route::get('/myProperty', [ClientsModuleController::class, 'myProperty'])->name('myProperty'); 
});

// Route::middleware(['guestalertclient:client'])->group(function () {
//     Route::get('/register', [AuthController::class, 'showRegister'])->name('show.register');
//     Route::get('/login', [AuthController::class, 'showLogin'])->name('show.login');
//     Route::post('/register', [AuthController::class, 'register'])->name('register');
//     Route::post('/login', [AuthController::class, 'login'])->name('login');
//     Route::get('/', [PagesController::class, 'Home'])->name('home');
//     Route::get('/listings', [PagesController::class, 'Listings'])->name('listings');
//     Route::get('/services', [PagesController::class, 'Services'])->name('services');
//     Route::get('/about', [PagesController::class, 'About'])->name('about');
// });

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
