<?php

namespace App\Http\Controllers\Master;

use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\AddressBook;
use App\Models\Addresstype;
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
        $customers = Customer::withCount('addressBooks')->paginate(10);
        return view('master.customer.list', ['customers' => $customers]);
    }

    public function AddAddress($id)
    {
        return view('master.customer.address-add', ['customerId' => $id]);
    }

    public function editAddress($id)
    {
        return view('master.customer.address-edit', ['customerId' => $id]);
    }

   
  
    public function editCustomer($id)
    {
        $customer = Customer::select('customer_id', 'customer_name', 'tss_expirydate', 'product_id', 'amc', 'tss_status', 'staff_id', 'profile_status', 'remarks', 'tss_adminemail')
            ->where('customer_id', $id)
            ->first();

        $products = Product::all();
        $users = User::all();

        return view('master.customer.edit_customer', ['products' => $products, 'users' => $users, 'customer' => $customer]);
    }


    public function add()
    {
        $products = Product::all();
        $users = User::all();
        return view('master.customer.add', ['products' => $products, 'users' => $users]);
    }

    public function store(Request $request)
    {
        $id = $this->getMaxCustomerId();

        Customer::create([
            'customer_id' => $id,
            'customer_name' => $request->name,
            'product_id' => $request->product_id,
            'amc' => $request->amc,
            'tss_status' => $request->tss_status,
            'tss_expirydate' => $request->tss_expirydate,
            'tss_adminemail' => $request->tss_adminemail,
            'profile_status' => $request->profile_status,
            'staff_id' => $request->executive_id,
            'remarks' => $request->remarks
        ]);

        return redirect('/master/customers')->with('message', 'Customer created successfully!');
    }

    private function getMaxCustomerId()
    {
        $maxId = Customer::max('customer_id');
        return $maxId ? $maxId + 1 : 1;
    }

    
}
