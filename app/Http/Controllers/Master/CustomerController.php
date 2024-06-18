<?php

namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    public function index()
    { 
        $query = Customer::query();
        return view('master.customer.list',['customers' => $query->paginate(10)]);
    }
 
    
}
