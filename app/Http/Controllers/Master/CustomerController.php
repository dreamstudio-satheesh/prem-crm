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
        return view('master.customer.add',['customers' => $query->paginate(10)]);
    }

    public function add()
    { 
        $query = Customer::query();
        return view('master.customer.add',['customers' => $query->paginate(10)]);
    }
   
    public function store(Request $request)
    {
        echo 'hi';
    }
    
}
