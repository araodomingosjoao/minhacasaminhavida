<?php

use App\Http\Controllers\BrokerController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertieController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitController;
use App\Mail\VisitNotification;
use App\Models\Client;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

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
// Route::get('teste', function(){
//     $client = Client::find(3);
//     $visit = Visit::find(1);
        
//     if ($client) {
//         $clientEmail = $client->email;
//         dd(Mail::to($clientEmail)->send(new VisitNotification($visit)));
//     }
// });
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::get('/email/verify/resend', [EmailVerificationController::class, 'resend'])->name('verification.resend');



Route::middleware(['auth', 'verified'])->group(function () {

    // Rotas do dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rotas do usuário
    Route::get('/', [UserController::class, 'index']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas de calendário
    Route::prefix('calendars')->name('calendars.')->group(function () {
        Route::get('', [CalendarController::class, 'index'])->name('index');
        Route::get('events', [CalendarController::class, 'getEvents'])->name('events');
    });

    // Rotas de visitas
    Route::prefix('visits')->name('visits.')->group(function () {
        Route::get('', [VisitController::class, 'index'])->name('index');
        Route::get('new', [VisitController::class, 'new'])->name('new');
        Route::post('store', [VisitController::class, 'store'])->name('store');
        Route::get('{id}/edit', [VisitController::class, 'edit'])->name('edit');
        Route::patch('{id}/update', [VisitController::class, 'update'])->name('update');
        Route::delete('{id}', [VisitController::class, 'delete'])->name('delete');
    });

    // Rotas de propriedades
    Route::prefix('properties')->name('properties.')->group(function () {
        Route::get('', [PropertieController::class, 'index'])->name('index');
        Route::get('new', [PropertieController::class, 'new'])->name('new');
        Route::post('store', [PropertieController::class, 'store'])->name('store');
        Route::get('{id}/edit', [PropertieController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [PropertieController::class, 'update'])->name('update');
        Route::delete('{id}', [PropertieController::class, 'delete'])->name('delete');
        Route::get('{id}/images', [PropertieController::class, 'showImages'])->name('showImages');
        Route::post('uploadImage/{id}', [PropertieController::class, 'uploadImage'])->name('uploadImage');
        Route::delete('{propertie}/images/{image}', [PropertieController::class, 'deleteImage'])->name('deleteImage');
    });

    // Rotas de clientes
    Route::prefix('clients')->name('clients.')->group(function () {
        Route::get('', [ClientController::class, 'index'])->name('index');
        Route::get('new', [ClientController::class, 'new'])->name('new');
        Route::post('store', [ClientController::class, 'store'])->name('store');
        Route::get('{id}/edit', [ClientController::class, 'edit'])->name('edit');
        Route::patch('{id}/update', [ClientController::class, 'update'])->name('update');
        Route::delete('{id}', [ClientController::class, 'delete'])->name('delete');
    });

    // Rotas de corretores
    Route::prefix('brokers')->name('brokers.')->group(function () {
        Route::get('', [BrokerController::class, 'index'])->name('index');
        Route::get('new', [BrokerController::class, 'new'])->name('new');
        Route::post('store', [BrokerController::class, 'store'])->name('store');
        Route::get('{id}/edit', [BrokerController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch'], '{id}/update', [BrokerController::class, 'update'])->name('update');
        Route::delete('{id}', [BrokerController::class, 'delete'])->name('delete');
    });

    // Rotas de usuários
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('index');
        Route::get('new', [UserController::class, 'new'])->name('new');
        Route::post('store', [UserController::class, 'store'])->name('store');
        Route::get('{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::patch('{id}/update', [UserController::class, 'update'])->name('update');
        Route::delete('{id}', [UserController::class, 'delete'])->name('delete');
    });
});

// require __DIR__.'/auth.php';

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();
