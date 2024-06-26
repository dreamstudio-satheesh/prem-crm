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

    public function industry()
    {
        return view('master.industry');
    } 
   
    
    public function products()
    {
        return view('master.products');
    }

    

    public function user()
    {
        return view('master.user');
    }

   

    public function role()
    {
        return view('master.role');
    }


   
    public function addresstype()
    {
        return view('addresstype');
    }

    public function customertype()
    {
        return view('customertype');
    }

  



    
}
