<?php

use App\Livewire\Bundles;
use App\Livewire\Garments;
use App\Livewire\Checkpoints;
use App\Livewire\AssignBundle;
use App\Livewire\GarmentTracking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Transactions\OnsiteEntryController; 
;

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

Route::get('/transactions/onsiteentry', [App\Http\Controllers\Transactions\OnsiteEntryController::class, 'index'])->name('onsiteentry'); 


//Route::get('transactions/trnenquiry', [Transactions\TrnEnquiryController::class, 'index']);  
//Route::get('transactions/trnenquiry/create', [Transactions\TrnEnquiryController::class, 'create']);  
//Route::post('transactions/trnenquiry/store', [Transactions\TrnEnquiryController::class, 'store']);  
//::get('transactions/trnenquiry/edit/{number?}', [Transactions\TrnEnquiryController::class, 'edit']);  

//Route::post('transactions/trnenquiry/update', [Transactions\TrnEnquiryController::class, 'update']);  
//Route::get('transactions/trnenquiry/delete/{number?}', [Transactions\TrnEnquiryController::class, 'delete']);  //