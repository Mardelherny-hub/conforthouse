<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Operation;
use App\Models\PropertyType;
use App\Models\Status;
use App\Models\Address;
use App\Models\City;
use App\Models\AutonomousCommunity;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Helpers\LibreTranslateHelper;
use App\Models\PropertyTranslation;
use App\Helpers\BreadcrumbHelper;
use Illuminate\Support\Facades\Log;


class AdminPropertyController extends Controller
{
    public function index()
    {
        $properties = Property::paginate(10);

        $breadcrumbs = BreadcrumbHelper::generate([
            'Escritorio' => route('admin.dashboard'),
            'Propiedades' => route('admin.properties.index'),
            'Sección Actual' => null
        ]);

        return view('admin.properties.index', compact('properties', 'breadcrumbs'));
    }

    public function create()
    {
        return view('admin.properties.create');
    }

    public function store(Request $request)
    {
       // se maneja desde el componente de Livewire
    }

    public function edit(Property $property)
    {
        $property = Property::with('translations')->with('operation')->find($property->id);
        $operations = Operation::all();
        $propertyTypes = PropertyType::all();
        $statuses = Status::all();
        $addresses = Address::all();
        //$cities = City::all();
        //$autonomous_communities = AutonomousCommunity::all();
        //$provinces = Province::all();
        //dd($property);
        return view('admin.properties.edit', compact('property', 'operations', 'propertyTypes', 'statuses', 'addresses'));
    }

    public function show(Property $property)
    {
        $property = Property::with('translations')->find($property->id);
        return view('admin.properties.show', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'location' => 'required|string|max:255',
        ]);

        $property->update($validated);

        return redirect()->route('admin.properties.index');
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('admin.properties.index');
    }
}
