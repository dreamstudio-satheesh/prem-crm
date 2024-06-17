<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function company()
    {
        return view('company');
    }

    public function customers()
    {
        return view('customers');
    }
   
    public function addresstype()
    {
        return view('addresstype');
    }

    public function customertype()
    {
        return view('customertype');
    }

    public function industry()
    {
        return view('industry');
    }


    public function user()
    {
        return view('user');
    }

    public function contacts()
    {
        return view('contact');
    }
   
    
    public function products()
    {
        return view('products');
    }


    public function role()
    {
        return view('role');
    }



    
}
