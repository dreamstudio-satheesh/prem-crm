<?php

namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;

use App\Models\Customer;
use App\Models\Addressbook;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
class CustomerController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    public function index()
    {  
        $query = Customer::getall();
        return view('master.customer.list',['customers' => $query]);
    }
    
    public function editaddressnew($id)
    {   
       
        $rscustomer = DB::table('customers')   
        ->select('customer_id','customer_name' )               
        ->where('customer_id',$id) 
        ->get();   

        $addresstype= DB::table('addresstype')            
                ->select('id','name')  
                ->orderBy('name', 'asc')             
               ->get();    
      
      
        return view('master.customer.editaddressnew',['addresstype'=>$addresstype,'rscustomer'=>$rscustomer]); 
    }
    public function saveaddressnew(Request $request)
    {
       
       // customeraddress_id

        $i=0;
        $id= $this->getmaxaddress(); 
        foreach($request->seladdresstype as $arritem)
        {
            Addressbook::create(['id'=>$id, 
                                  'indx'=>$i+1,
                                  'customer_code'=>$request->customer_code,              
                                  'addresstype'=>$arritem,
                                  'contact_person'=>$request->contactperson[$i],                                       
                                  'mobileno'=>$request->mobileno[$i],                                      
                                  'phoneno'=>$request->phoneno[$i],
                                  'email'=>$request->email[$i]  ]);
            $i=$i+1;
        }   

        Customer::where('customer_id',$request->customer_code)->update([ 
            'customeraddress_id'=>$id    
            ]); 

        $msg = [
            'message' => 'Customer Address  created successfully!' ];
          return  redirect('/master/customers')->with($msg); 
    } 
    
    public function editcustomer($id)
    {   
       
       $rscustomer = DB::table('customers')    
        ->select('customers.customer_id','customer_name','tss_expirydate','product_id','amc',
        'tss_status',
        'remarks','tss_adminemail')               
        ->where('customers.customer_id',$id)  
        ->get();  
        
        $product =  Product::getall();  
        $user =  User::getall();  
      
        return view('master.customer.editcustomer',['products'=>$product,
                         'user'=>$user,'rscustomer'=>$rscustomer]); 
    }



    public function editaddress($id)
    {   
       
       $rscustomer = DB::table('customers')   
        ->Join('addressbook', 'addressbook.customer_code', '=', 'customers.customer_id')
        ->select('customers.customer_id','customer_name','addressbook.id' )               
        ->where('addressbook.id',$id) 
        ->distinct()
        ->get();  
        

        $rsaddressbook = DB::table('addressbook')    
        ->select('id','indx','customer_code','addresstype','contact_person',
        'mobileno','phoneno','email' )               
         ->where('id',$id)
         ->get();

        $addresstype= DB::table('addresstype')            
                ->select('id','name')  
                ->orderBy('name', 'asc')             
               ->get();    
      
      
        return view('master.customer.editaddress',['addresstype'=>$addresstype,'rscustomer'=>$rscustomer,'rsaddressbook'=>$rsaddressbook]); 
    }
    public function saveaddress(Request $request)
    {  
        $i=0;
        DB::table('addressbook')->where('id',$request->id)->delete();
      
        foreach($request->seladdresstype as $arritem)
        {
            Addressbook::create(['id'=>$request->id,
                                  'indx'=>$i+1,
                                  'customer_code'=>$request->customer_code,              
                                  'addresstype'=>$arritem,
                                  'contact_person'=>$request->contactperson[$i],                                       
                                  'mobileno'=>$request->mobileno[$i],                                      
                                  'phoneno'=>$request->phoneno[$i],
                                  'email'=>$request->email[$i]  ]);
            $i=$i+1;
        }   

        Customer::where('customer_id',$request->customer_code)->update([ 
            'customeraddress_id'=>$request->id   
            ]); 

        $msg = [
            'message' => 'Customer Address Updated successfully!' ];
          return  redirect('/master/customers')->with($msg); 
    } 
   

    public function fetchaddresstype()
    {   
       $addresstype= DB::table('addresstype')            
                ->select('id','name')  
                ->orderBy('name', 'asc')             
               ->get();    
               $output ='';
         foreach($addresstype as $row)
               {
                   $output .='<option value='.$row->id.'>'.$row->name.'</option>';
               }         
                echo $output;
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
    
    private  function getmaxaddress()
    {
        $retvalue=   DB::table('addressbook')->max('id')   ;
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
