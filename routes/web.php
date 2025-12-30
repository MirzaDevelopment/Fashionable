<?php

use App\Http\Controllers\CreateAdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Product;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;
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

Route::get('/assets/{filename}', function ($filename) {
    $path = public_path('assets/' . $filename);

    if (file_exists($path)) {
        $headers = [
            'Cache-Control' => 'public, max-age=31536000, immutable',
            'Expires' => now()->addYears(1)->toDateString(),
        ];

        return Response::file($path, $headers);
    }

    abort(404);
});

//Product first page route 

Route::get('/shop', function () {
    return view('firstpage');
})->name('firstpage');

//User management resource route
Route::resource("users", UserController::class)->only(['store', 'edit', 'update'])->middleware(['auth', 'verified']);

/***Custom routes***/
Route::middleware(['auth', 'verified'])->group(function () {
    //Admin route (authorised in controller)
    Route::get('/dashboard', [DashboardController::class, 'countUsersAndProducts'], function () {
    })->name('dashboard');
    //Guest route
    Route::get('/dashboardusers', function () {
        if(auth()->user()->role=="guest"){
        return view("dashboardusers");
        }
   
    })->name('dashboardusers');

    //Livewire users search route
    Route::get('/users', function (User $user) {
        Gate::authorize('create', $user); //Authorisation for admin
        return view('users'); //Authenticated and mail-verified
    })->name('users');
    //Add user by Admin view (safety route)
    Route::get('/add-user', function (User $user) {
        Gate::authorize('create', $user); //Authorisation for admin
        return view('adduser');
    })->name('adduser');
    Route::get('/deleted-users', function (User $user) {
        Gate::authorize('create', $user); //Authorisation for admin
        return view('deleted-users'); //Authenticated and mail-verified
    })->name('deleted-users');
    Route::get('/categories', function (User $user) {
        Gate::authorize('create', $user); //Authorisation for admin
        return view('categories'); //Authenticated and mail-verified
    })->name('categories');
    //Livewire product routes
    Route::get('/addproduct', function (User $user) {
        Gate::authorize('create', $user); //Authorisation for admin
        return view('addproduct'); //Authenticated and mail-verified
    })->name('addproduct');
    //Stock management 
    Route::get('/stock-management/{id}', function (User $user) {
        Gate::authorize('create', $user); //Authorisation for admin
        return view('stock-management'); 
    })->name('stock-management');
    //Show, modify and delete products
    Route::get('/products', function (User $user) {
        Gate::authorize('create', $user); //Authorisation for admin
        return view('products'); //Authenticated and mail-verified
    })->name('products');
    Route::get('/deleted-products', function (User $user) {
        Gate::authorize('create', $user); //Authorisation for admin
        return view('deleted-products'); //Authenticated and mail-verified
    })->name('deleted-products');
    Route::get('/edit-products/{id}', function (User $user) {
        Gate::authorize('create', $user); //Authorisation for admin
        return view('editproduct'); //Authenticated and mail-verified
    })->name('editproduct');
});

/***Breeze middleware***/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

//Route::get('createAdmin', [CreateAdminController::class, 'createAdmin']); Single use only


//Statistics route
Route::get('/statistics', function () {
    return view('statistics');
})->middleware(['auth', 'verified'])->name('statistics');


//Google login route
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
