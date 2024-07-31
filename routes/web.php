<?php


use App\Livewire\AddCustomer;
use App\Livewire\CustomerList;
use App\Livewire\EditCustomer;
use App\Livewire\OnlineCallList;
use App\Livewire\OnsiteVisitList;
use App\Livewire\CompletedCallList;
use App\Livewire\Master\RoleMaster;
use App\Livewire\Master\UserMaster;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Livewire\Master\LicenceMaster;
use App\Livewire\Master\ProductMaster;
use App\Livewire\Master\IndustryMaster;
use App\Livewire\Master\LocationMaster;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use App\Livewire\Master\CustomertypeMaster;
use App\Http\Controllers\SettingsController;
use App\Livewire\Master\NatureOfIssueMaster;
use App\Http\Controllers\OnlineCallController;
use App\Http\Controllers\OnsiteVisitController;
use App\Http\Controllers\CustomerImportController;
use App\Http\Controllers\EmailMarketingController;

Route::get('/', function () {
  return redirect('home');
});

Route::get('/customer-page', function () {
  return view('customer-page');
});

Route::get('/customer-page2', function () {
  return view('customer-page2');
});

Auth::routes(['register' => false,  'reset' => false, 'verify' => false,]);

Route::get('/logout',  [App\Http\Controllers\Auth\LoginController::class, 'logout']);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/user', UserMaster::class);
Route::get('/role', RoleMaster::class);
Route::get('/product', ProductMaster::class);
Route::get('/industry', IndustryMaster::class);
Route::get('/customertype', CustomertypeMaster::class);
Route::get('/location', LocationMaster::class);
Route::get('/licence', LicenceMaster::class);
Route::get('/nature-of-issue', NatureOfIssueMaster::class);


Route::get('master/customers/add', AddCustomer::class)->name('customers.add');
Route::get('/customers/{customer}/edit', EditCustomer::class)->name('customers.edit');
//Route::get('/customers/{customer}/edit', \App\Livewire\EditCustomer::class)->name('customers.edit');





Route::get('/master/customers', CustomerList::class)->name('customers.index');
Route::get('master/customers/add-address/{customerId}', \App\Livewire\AddAddress::class)->name('customers.addAddress');
Route::get('master/customers/edit-address/{customerId}', \App\Livewire\EditAddress::class)->name('customers.editAddress');


Route::get('customer/import', [CustomerImportController::class, 'showImportForm'])->name('customer_import.show');
Route::post('customer/import/upload', [CustomerImportController::class, 'uploadAndPrepareImport'])->name('customer_import.upload');
Route::post('customer/import/import', [CustomerImportController::class, 'importData'])->name('customer_import.import');


Route::get('/onsite-visits', OnsiteVisitList::class)->name('onsite-visits.index');
Route::get('onsite-visits/create', [OnsiteVisitController::class, 'create'])->name('onsite-visits.create');
Route::post('onsite-visits', [OnsiteVisitController::class, 'store'])->name('onsite-visits.store');
Route::get('onsite-visits/contact-persons/{customerId}', [OnsiteVisitController::class, 'getContactPersons']);
Route::get('onsite-visits/contact-person-mobile/{contactPersonId}', [OnsiteVisitController::class, 'getContactPersonMobile']);
Route::get('/onsite-visits/{id}/edit', [OnsiteVisitController::class, 'edit'])->name('onsite-visits.edit');
Route::post('/onsite-visits/{id}', [OnsiteVisitController::class, 'update'])->name('onsite-visits.update');

Route::get('/completed-calls', CompletedCallList::class)->name('completed-calls.index');

Route::post('/customers', [OnsiteVisitController::class, 'store_customer'])->name('customers.create');
Route::post('/contact-persons', [OnsiteVisitController::class, 'storeContactPerson']);
Route::get('/customer-types', [OnsiteVisitController::class, 'getCustomerTypes']);

Route::post('/online-calls/keep-alive/{id}', 'OnlineCallController@keepAlive')
  ->middleware('auth')
  ->name('online-calls.reset-editing');

Route::get('/test-logging', function () {
  Log::info('This is a test log entry.');
  return 'Log entry created.';
});

Route::get('/test-email', function () {
  try {
      Mail::raw('This is a test email.', function ($message) {
          $message->to('satheesh@dreamstudio.in')
                  ->subject('Test Email');
      });
      return 'Test email sent successfully.';
  } catch (\Exception $e) {
      return 'Error sending test email: ' . $e->getMessage();
  }
});


Route::get('/online-calls', OnlineCallList::class)->name('online-calls.index');
Route::get('online-calls/create', [OnlineCallController::class, 'create'])->name('online-calls.create');
Route::post('online-calls', [OnlineCallController::class, 'store'])->name('online-calls.store');
Route::get('/online-calls/{id}/edit', [OnlineCallController::class, 'edit'])->name('online-calls.edit');
Route::post('/online-calls/{id}', [OnlineCallController::class, 'update'])->name('online-calls.update');


//Route::get('/onsite-visits/create', CreateOnsiteVisit::class)->name('onsite-visits.create'); 




Route::get('/email-settings', [SettingsController::class, 'edit_email'])->name('email-settings.edit');
Route::post('/email-settings', [SettingsController::class, 'update_email'])->name('email-settings.update');

/* Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update'); */


Route::get('/marketing/email', [EmailMarketingController::class, 'create'])->name('marketing.email.create');
Route::post('/send/marketing/email', [EmailMarketingController::class, 'send'])->name('send.marketing.email');

Route::resource('leads', LeadController::class);
