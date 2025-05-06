<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientsModuleController;
use App\Http\Controllers\AdminModuleController;
use App\Http\Controllers\AgentModuleController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// Public Pages
Route::get('/', [PagesController::class, 'Home'])->name('home');
Route::get('/listings', [PagesController::class, 'Listings'])->name('listings');
Route::get('/services', [PagesController::class, 'Services'])->name('services');
Route::get('/about', [PagesController::class, 'About'])->name('about');
Route::get('/pubViewProperties/{id}', [PagesController::class, 'pubViewProperties'])->name('pubViewProperties');







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
    Route::get('/agentsCreate', [AdminModuleController::class, 'agentsCreate'])->name('agentsCreate');
    Route::post('/agentsRegister', [AdminModuleController::class, 'agentsRegister'])->name('agentsRegister');
    Route::get('/deactivateAgent/{id}', [AdminModuleController::class, 'deactivateAgent'])->name('deactivateAgent');
    Route::get('/viewAgent/{id}', [AdminModuleController::class, 'viewAgent'])->name('viewAgent');
});


Route::middleware(['guestwithalert:admin', 'guestwithalert:client', 'guestwithalert:agent'])->group(function () {
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



    // Route::get('/agentMessages', [AgentModuleController::class, 'agentMessages'])->name('agentMessages');

    // Route::get('/agentMessages/{property_id}/{client_id}', [AgentModuleController::class, 'viewConversation'])->name('agent.conversation');

    // Route::post('/agentMessages/send', [AgentModuleController::class, 'sendMessage'])->name('agent.sendMessage');

    Route::get('/agentMessages', [AgentModuleController::class, 'agentMessages'])->name('agentMessages');

    Route::get('/agentMessages/{property_id}/{client_id}', [AgentModuleController::class, 'viewConversation'])->name('agent.conversation');

    Route::post('/agentMessages/send', [AgentModuleController::class, 'sendMessage'])->name('agent.sendMessage');



    Route::get('/agentProperties', [AgentModuleController::class, 'agentProperties'])->name('agentProperties');
    Route::get('/createProperty', [AgentModuleController::class, 'createProperty'])->name('createProperty');
    Route::post('/storeProperty', [AgentModuleController::class, 'storeProperty'])->name('storeProperty');
    Route::get('/agentProperties/{id}', [AgentModuleController::class, 'viewProperties'])->name('viewProperties');
    Route::get('/editProperty/{id}', [AgentModuleController::class, 'editProperty'])->name('editProperty');
    Route::put('/updateProperty/{id}', [AgentModuleController::class, 'updateProperty'])->name('updateProperty');
    Route::get('/agentSoldProperties', [AgentModuleController::class, 'agentSoldProperties'])->name('agentSoldProperties');
    Route::get('/agentArchiveProperties', [AgentModuleController::class, 'agentArchiveProperties'])->name('agentArchiveProperties');
    Route::post('/agent/property/{id}/archive', [AgentModuleController::class, 'archive'])->name('property.archive');
    Route::post('/agent/properties/{id}/restore', [AgentModuleController::class, 'restoreProperty'])->name('property.restore');






});

// Client views
Route::middleware(['auth:client'])->group(function () {
    Route::get('/clientsProfile', [ClientsModuleController::class, 'clientsProfile'])->name('clientsProfile');
    Route::post('/updateProfilePic', [ClientsModuleController::class, 'updateProfilePic'])->name('updateProfilePic');
    Route::get('/clientsListings', [ClientsModuleController::class, 'clientsListings'])->name('clientsListings');
    Route::get('/clientsFavorites', [ClientsModuleController::class, 'clientsFavorites'])->name('clientsFavorites');
    Route::get('/maps', [ClientsModuleController::class, 'maps'])->name('maps');



    // Route::get('/messages', [ClientsModuleController::class, 'messages'])->name('messages');
    // Route::get('/messages/{property_id}/{agent_id}', [ClientsModuleController::class, 'viewConversation'])->name('client.conversation');
    // Route::post('/messages/send', [ClientsModuleController::class, 'sendMessage'])->name('client.sendMessage');
    Route::get('/messages', [ClientsModuleController::class, 'messages'])->name('messages');
    Route::get('/messages/{property_id}/{agent_id}', [ClientsModuleController::class, 'viewConversation'])->name('client.conversation');
    Route::post('/messages/send', [ClientsModuleController::class, 'sendMessage'])->name('client.sendMessage');
 


    Route::get('/myProperty', [ClientsModuleController::class, 'myProperty'])->name('myProperty');
    
    Route::get('/clientsViewProperties/{id}', [ClientsModuleController::class, 'clientsViewProperties'])->name('clientsViewProperties');

        Route::post('/favoriteProperty/{propertyId}', [ClientsModuleController::class, 'favoriteProperty'])->name('favoriteProperty');

 
    
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
