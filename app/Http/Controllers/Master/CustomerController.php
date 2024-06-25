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
        $customers = Customer::getAll();
        return view('master.customer.list', ['customers' => $customers]);
    }

    public function editAddressNew($id)
    {
        $customer = Customer::select('customer_id', 'customer_name')
            ->where('customer_id', $id)
            ->first();

        $addressTypes = Addresstype::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        return view('master.customer.edit_address_new', ['addressTypes' => $addressTypes, 'customer' => $customer]);
    }

    public function saveAddressNew(Request $request)
    {
        $id = $this->getMaxAddressId();
        foreach ($request->seladdresstype as $index => $addressType) {
            AddressBook::create([
                'address_id' => $id,
                'index' => $index + 1,
                'customer_id' => $request->customer_code,
                'address_type_id' => $addressType,
                'contact_person' => $request->contactperson[$index],
                'mobile_no' => $request->mobileno[$index],
                'phone_no' => $request->phoneno[$index],
                'email' => $request->email[$index]
            ]);
        }

        Customer::where('customer_id', $request->customer_code)
            ->update(['customer_address_id' => $id]);

        return redirect('/master/customers')->with('message', 'Customer Address created successfully!');
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

    public function saveCustomer(Request $request)
    {
        Customer::where('customer_id', $request->id)
            ->update([
                'customer_name' => $request->name,
                'product_id' => $request->product_id,
                'amc' => $request->amc,
                'tss_status' => $request->tssstatus,
                'tss_expirydate' => $request->tssdate,
                'tss_adminemail' => $request->tssadminemail,
                'profile_status' => $request->profilestatus,
                'staff_id' => $request->executive_id,
                'remarks' => $request->remarks
            ]);

        return redirect('/master/customers')->with('message', 'Customer updated successfully!');
    }

    public function editAddress($id)
    {
        $customer = Customer::join('address_books', 'address_books.customer_id', '=', 'customers.customer_id')
            ->select('customers.customer_id', 'customer_name', 'address_books.address_id')
            ->where('address_books.address_id', $id)
            ->distinct()
            ->first();

        $addressBook = AddressBook::select('address_id', 'index', 'customer_id', 'address_type_id', 'contact_person', 'mobile_no', 'phone_no', 'email')
            ->where('address_id', $id)
            ->get();

        $addressTypes = Addresstype::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        return view('master.customer.edit_address', ['addressTypes' => $addressTypes, 'customer' => $customer, 'addressBook' => $addressBook]);
    }

    public function saveAddress(Request $request)
    {
        AddressBook::where('address_id', $request->id)->delete();

        foreach ($request->seladdresstype as $index => $addressType) {
            AddressBook::create([
                'address_id' => $request->id,
                'index' => $index + 1,
                'customer_id' => $request->customer_code,
                'address_type_id' => $addressType,
                'contact_person' => $request->contactperson[$index],
                'mobile_no' => $request->mobileno[$index],
                'phone_no' => $request->phoneno[$index],
                'email' => $request->email[$index]
            ]);
        }

        Customer::where('customer_id', $request->customer_code)
            ->update(['customer_address_id' => $request->id]);

        return redirect('/master/customers')->with('message', 'Customer Address updated successfully!');
    }

    public function fetchAddressTypes()
    {
        $addressTypes = Addresstype::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        $output = '';
        foreach ($addressTypes as $row) {
            $output .= '<option value=' . $row->id . '>' . $row->name . '</option>';
        }

        return response($output);
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
            'tss_status' => $request->tssstatus,
            'tss_expirydate' => $request->tssdate,
            'tss_adminemail' => $request->tssadminemail,
            'profile_status' => $request->profilestatus,
            'staff_id' => $request->executive_id,
            'remarks' => $request->remarks
        ]);

        return redirect('/master/customers')->with('message', 'Customer created successfully!');
    }

    private function getMaxAddressId()
    {
        $maxId = AddressBook::max('address_id');
        return $maxId ? $maxId + 1 : 1;
    }

    private function getMaxCustomerId()
    {
        $maxId = Customer::max('customer_id');
        return $maxId ? $maxId + 1 : 1;
    }

    public function edit(Request $request)
    {
        // Implementation needed
    }

    public function update(Request $request)
    {
        // Implementation needed
    }
}
