<?php

namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;

use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
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

    public function add()
    { 
       
        $product =  Product::getall();  
        $user =  User::getall();  
        return view('master.customer.add',['products' => $product,'user'=>$user]); 
    }
   
    public function store(Request $request)
    {
         
        $id= $this->getmax(); 
        $name =$request->name;$product_id =$request->product_id;
        
        $amc =$request->amc;
        $tssdate =$request->tssdate;// $enq_date =date("Y-m-d", strtotime($request->tssdate));
        $tssadminemail=$request->tssadminemail;$profilestatus=$request->profilestatus;
        $user_id=$request->executive_id  ;
        $remarks=$request->remarks  ;
        
        customer::create(['id'=>$id,
        'customer_name'=>$name, 
        'product_id'=>$product_id,                                  
        'amc'=>$amc,
        'tss_status'=>$request->tssstatus, 
        'tss_expirydate'=>$tssdate, 
        'tss_adminemail'=>$tssadminemail, 
        'profilestatus'=>$profilestatus,  
        'staff_id'=>$request->executive_id,   
        'remarks'=>$request->remarks]);

        $msg = [
            'message' => 'Customer Create created successfully!' ];
          return  redirect('/master/customers')->with($msg); 
    }

    private  function getmax()
    {
        $retvalue=Customer::max('customer_id');
        if ($retvalue === null)
        {
            $retvalue=1;
        }
        elseif ($retvalue >=1)
        {
            $retvalue=$retvalue+1;
        }
        return $retvalue;
    }
   


    public function edit(Request $requset)
    {
        echo 'hi';
    }

    public function update(Request $request)
    {
        echo 'hi';
    }
    
}
