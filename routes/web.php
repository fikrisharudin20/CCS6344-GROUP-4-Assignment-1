<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PurchasedEventController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route for user profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route for organiser and admin
    Route::middleware(['checkUserRole:organiser,admin'])->group(function () {
        // CRUD Events
        Route::get('/event', [EventController::class, 'allEvents'])->name('events.allEvents');
        Route::get('/event/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/event', [EventController::class, 'store'])->name('events.store');
        Route::get('/event/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/event/{event}/update', [EventController::class, 'update'])->name('events.update');
        Route::delete('/event/{event}/delete', [EventController::class, 'delete'])->name('events.delete');
        Route::get('/event/search/all', [EventController::class, 'searchAll'])->name('events.searchAll');
        Route::get('/event/filter/all', [EventController::class, 'filterAll'])->name('events.filterAll');

    });

    // Route for user and admin
    Route::middleware(['checkUserRole:user,admin'])->group(function () {
        // Browse Events
        Route::get('/event/browse', [EventController::class, 'browse'])->name('events.browse');
        Route::get('/event/search', [EventController::class, 'search'])->name('events.search');
        Route::get('/event/nearby', [EventController::class, 'findNearby'])->name('events.findNearby');
        Route::get('/event/filter', [EventController::class, 'filter'])->name('events.filter');
        
        // Cart
        Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store');
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');
        
        // Payment
        Route::get('/payment', [PaymentController::class, 'checkout'])->name('payment.checkout');
        Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');
        Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');

        // Ticket
        Route::delete('/purchased_events/{purchasedEvent}/delete', [PurchasedEventController::class, 'delete'])->name('purchased_events.delete');
        Route::get('/purchased_events', [PurchasedEventController::class, 'index'])->name('purchased_events.index');
        Route::get('/purchased_events/{ticketId}/receipt', [PurchasedEventController::class, 'receipt'])->name('purchased_events.receipt');
        Route::get('/tickets/search', [PurchasedEventController::class, 'search'])->name('tickets.search');
        Route::get('/tickets/filter', [PurchasedEventController::class, 'filter'])->name('tickets.filter');

    });
    
    // View Event Details
    Route::get('/event/view/{event}', [EventController::class, 'view'])->name('events.view');
});

require __DIR__.'/auth.php';
