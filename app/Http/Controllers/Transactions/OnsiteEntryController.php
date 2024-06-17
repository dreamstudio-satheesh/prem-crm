<?php

namespace App\Http\Controllers\Transactions;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class OnsiteEntryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index()
    {
       // return view('transactions.enquiry.list',compact('rsdata','rsdepartmentData'));
     //  transactions\onsiteentry
        return view('transactions.onsiteentry.list');
    }

     
    //transactions/onsiteentry


    
}
