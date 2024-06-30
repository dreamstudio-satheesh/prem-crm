<?php

namespace App\Http\Controllers\Master;


use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $customers = Customer::withCount('AddressBooks')->paginate(10);
        return view('master.customer.list', ['customers' => $customers]);
    }

 
    
}
