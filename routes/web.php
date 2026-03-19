<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/teste', [EventController::class, 'index']);

Route::get('/events/create', [EventController::class, 'create'])->middleware('auth');
Route::get('/events/{id}', [EventController::class, 'show']);
Route::post('/events', [EventController::class, 'store'])->middleware('auth');
Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('auth');
Route::get('/events/edit/{id}', [EventController::class, 'edit'])->middleware('auth');
Route::put('/events/update/{id}', [EventController::class, 'update'])->middleware('auth');

// Rota de pagamento
Route::get('/events/payment/{id}', [PaymentController::class, 'showPayment'])->middleware('auth');
Route::post('/events/payment/process', [PaymentController::class, 'processPayment'])->middleware('auth');

Route::post('/events/{event}/subscribe', [RegistrationController::class, 'subscribe'])->middleware('auth');

Route::get('/produtos', function () {
    $busca = request('search');
    return view('products', ['busca' => $busca]);
});

Route::get('/produtos_teste/{id?}', function ($id = null) {
    return view('product', ['id' => $id]);
});

Route::get('/dashboard', [EventController::class, 'dashboard'])->middleware('auth');

//antiga entrada direta no evento
Route::post('/events/join/{id}', [EventController::class, 'joinEvent'])->middleware('auth');
Route::delete('/events/leave/{id}', [EventController::class, 'leaveEvent'])->middleware('auth');
