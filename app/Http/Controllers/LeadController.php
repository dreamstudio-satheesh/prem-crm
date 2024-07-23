<?php

namespace App\Http\Controllers;


use App\Models\Lead; // Assuming your model name is Lead
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::all();
        return view('leads.index', compact('leads'));
    }

    public function create()
    {
        return view('leads.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required',
            'product_id' => 'required',
            'contact_no' => 'required',
            'status' => 'required',
            // Add other fields as necessary
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
        return view('leads.edit', compact('lead'));
    }

    public function update(Request $request, Lead $lead)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required',
            'product_id' => 'required',
            'contact_no' => 'required',
            'status' => 'required',
            // Validate other fields as necessary
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




