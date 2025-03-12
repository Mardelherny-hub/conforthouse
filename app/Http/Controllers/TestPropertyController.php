<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;


class TestPropertyController extends Controller
{
    public function show($id)
    {
        $property = Property::with('images')->findOrFail($id);
        dd($property);
        return view('properties.show', compact('property'));
    }
}
