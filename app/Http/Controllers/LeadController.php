<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Product;
use App\Models\Customer; // Assuming you have a Customer model
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::with('product', 'customer')->paginate(15); // Eager load related data
        return view('leads.index', compact('leads'));
    }

    public function create()
    {
        $products = Product::all();
        $customers = Customer::all(); // Fetch all customers for dropdown
        return view('leads.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'amount' => 'nullable|numeric',
            'status' => 'required|string',
            'follow_up_date' => 'nullable|date',
        ]);

        Lead::create($validatedData);
        return redirect('/leads')->with('success', 'Lead created successfully!');
    }

    public function show(Lead $lead)
    {
        return view('leads.show', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        $products = Product::all();
        $customers = Customer::all(); // Fetch all customers for dropdown
        return view('leads.edit', compact('lead', 'products', 'customers'));
    }

    public function update(Request $request, Lead $lead)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'amount' => 'nullable|numeric',
            'status' => 'required|string',
            'follow_up_date' => 'nullable|date',
        ]);

        $lead->update($validatedData);
        return redirect('/leads')->with('success', 'Lead updated successfully!');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect('/leads')->with('success', 'Lead deleted successfully!');
    }
}
