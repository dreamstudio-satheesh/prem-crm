<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bundle;

class BundleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'lay_no' => 'required|string|max:255',
            'lot_no' => 'required|string|max:255',
            'po_no' => 'required|string|max:255',
            'style_no' => 'required|string|max:255',
            'size' => 'required|string|max:10',
            'qty' => 'required|integer',
            'barcode_from' => 'required|string|max:255',
            'barcode_to' => 'required|string|max:255',
        ]);

        $bundle = Bundle::createWithGarments($request->all());

        return response()->json($bundle, 201);
    }
}
