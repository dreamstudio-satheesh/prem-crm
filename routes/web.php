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
use App\Livewire\CreateOnsiteVisit;
use App\Livewire\CustomerList;
use App\Livewire\OnsiteVisitList;

Route::get('/', function () {
    return redirect('home');
});

Route::get('/customer-page', function () {
  return view('customer-page');
});

Route::get('/customer-page2', function () {
  return view('customer-page2');
});

Auth::routes([  'register' => false,  'reset' => false, 'verify' => false,  ]);
  
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
Route::get('/customers/{customer}/edit', \App\Livewire\EditCustomer::class)->name('customers.edit');


Route::get('/master/customers', CustomerList::class)->name('customers.index'); 
Route::get('master/customers/add-address/{customerId}', \App\Livewire\AddAddress::class)->name('customers.addAddress');
Route::get('master/customers/edit-address/{customerId}', \App\Livewire\EditAddress::class)->name('customers.editAddress');

Route::get('/onsite-visits', OnsiteVisitList::class)->name('onsite-visits.index'); 
Route::get('/onsite-visits/create', CreateOnsiteVisit::class)->name('onsite-visits.create'); 


Route::get('/transactions/onsiteentry', [App\Http\Controllers\Transactions\OnsiteEntryController::class, 'index'])->name('onsiteentry'); 


//Route::get('transactions/trnenquiry', [Transactions\TrnEnquiryController::class, 'index']);  
//Route::get('transactions/trnenquiry/create', [Transactions\TrnEnquiryController::class, 'create']);  
//Route::post('transactions/trnenquiry/store', [Transactions\TrnEnquiryController::class, 'store']);  
//::get('transactions/trnenquiry/edit/{number?}', [Transactions\TrnEnquiryController::class, 'edit']);  

//Route::post('transactions/trnenquiry/update', [Transactions\TrnEnquiryController::class, 'update']);  
//Route::get('transactions/trnenquiry/delete/{number?}', [Transactions\TrnEnquiryController::class, 'delete']);  //