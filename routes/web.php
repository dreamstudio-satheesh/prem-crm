<?php


use App\Livewire\AddCustomer;
use App\Livewire\Master\RoleMaster;
use App\Livewire\Master\UserMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\Master\LicenceMaster;
use App\Livewire\Master\ProductMaster;
use App\Livewire\Master\IndustryMaster;
use App\Livewire\Master\LocationMaster;
use App\Http\Controllers\HomeController;
use App\Livewire\Master\CustomertypeMaster;
use App\Http\Controllers\Master\CustomerController;

Route::get('/', function () {
    return redirect('home');
});

Route::get('/customer-page', function () {
  return view('customer-page');
});

Route::get('/customer-page2', function () {
  return view('customer-page2');
});



Auth::routes([

    'register' => false, // Register Routes...
  
    'reset' => false, // Reset Password Routes...
  
    'verify' => false, // Email Verification Routes...
  
  ]);
  
  Route::get('/logout',  [App\Http\Controllers\Auth\LoginController::class, 'logout']);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/user', UserMaster::class);  
Route::get('/role', RoleMaster::class); 
Route::get('/product', ProductMaster::class);    
Route::get('/industry', IndustryMaster::class); 
Route::get('/customertype', CustomertypeMaster::class); 
Route::get('/location', LocationMaster::class); 
Route::get('/licence', LicenceMaster::class); 


Route::get('master/customers/add', AddCustomer::class)->name('customers.add'); 

Route::get('/master/customers', [CustomerController::class, 'index'])->name('customers.index'); 
Route::get('master/customers/add-address/{id}', [CustomerController::class, 'AddAddress'])->name('customers.AddAddress');
Route::post('master/customers/save-address', [CustomerController::class, 'saveAddress'])->name('customers.saveAddress');
Route::get('master/customers/edit-customer/{id}', [CustomerController::class, 'editCustomer'])->name('customers.editCustomer');
Route::post('master/customers/save-customer', [CustomerController::class, 'saveCustomer'])->name('customers.saveCustomer');
Route::get('master/customers/edit-address/{id}', [CustomerController::class, 'editAddress'])->name('customers.editAddress');
Route::post('master/customers/save-address', [CustomerController::class, 'saveAddress'])->name('customers.saveAddress');
Route::post('master/customers/store', [CustomerController::class, 'store'])->name('customers.store');
Route::get('master/customers/fetch-address-types', [CustomerController::class, 'fetchAddressTypes'])->name('customers.fetchAddressTypes');


Route::get('/transactions/onsiteentry', [App\Http\Controllers\Transactions\OnsiteEntryController::class, 'index'])->name('onsiteentry'); 


//Route::get('transactions/trnenquiry', [Transactions\TrnEnquiryController::class, 'index']);  
//Route::get('transactions/trnenquiry/create', [Transactions\TrnEnquiryController::class, 'create']);  
//Route::post('transactions/trnenquiry/store', [Transactions\TrnEnquiryController::class, 'store']);  
//::get('transactions/trnenquiry/edit/{number?}', [Transactions\TrnEnquiryController::class, 'edit']);  

//Route::post('transactions/trnenquiry/update', [Transactions\TrnEnquiryController::class, 'update']);  
//Route::get('transactions/trnenquiry/delete/{number?}', [Transactions\TrnEnquiryController::class, 'delete']);  //