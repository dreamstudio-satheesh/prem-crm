<?php

use App\Livewire\Bundles;
use App\Livewire\Garments;
use App\Livewire\Checkpoints;
use App\Livewire\AssignBundle;
use App\Livewire\GarmentTracking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('home');
});

Route::get('/companies', function () {
    
    return view('company-master');
});

Auth::routes([

    'register' => false, // Register Routes...
  
    'reset' => false, // Reset Password Routes...
  
    'verify' => false, // Email Verification Routes...
  
  ]);
  
  Route::get('/logout',  [App\Http\Controllers\Auth\LoginController::class, 'logout']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/company', [App\Http\Controllers\HomeController::class, 'company'])->name('company');  

Route::get('/customers', [App\Http\Controllers\HomeController::class, 'customers'])->name('customers');  

Route::get('/user', [App\Http\Controllers\HomeController::class, 'user'])->name('user');   

Route::get('/role', [App\Http\Controllers\HomeController::class, 'role'])->name('role');  

Route::get('/contacts', [App\Http\Controllers\HomeController::class, 'contacts'])->name('contacts');   

Route::get('/products', [App\Http\Controllers\HomeController::class, 'products'])->name('products');  
Route::get('/industry', [App\Http\Controllers\HomeController::class, 'industry'])->name('industry');  