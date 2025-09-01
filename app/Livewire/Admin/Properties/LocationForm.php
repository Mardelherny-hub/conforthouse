<?php

namespace App\Livewire\Admin\Properties;


use Livewire\Component;
use App\Models\Propieties;
use App\Models\Address;
use Illuminate\Support\Facades\Log;

class LocationForm extends Component
{
    public $property;
    public $street;
    public $number;
    public $floor;
    public $door;
    public $district;
    public $postal_code;
    public $city;
    public $province;
    public $autonomous_community;
    public $google_map;

    // Para mensajes de éxito o error
    public $successMessage = '';
    public $errorMessage = '';

    protected $rules = [
        'street' => 'required|string|max:255',
        'number' => 'required|integer',
        'floor' => 'nullable|string|max:255',
        'door' => 'nullable|string|max:255',
        'district' => 'nullable|string|max:255',
        'postal_code' => 'nullable|string|max:255',
        'city' => 'required|string|max:255',
        'province' => 'nullable|string|max:255',
        'autonomous_community' => 'nullable|string|max:255',
        'google_map' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'street.required' => 'El campo calle es obligatorio.',
        'street.string' => 'El campo calle debe ser un texto.',
        'street.max' => 'El campo calle no debe superar los 255 caracteres.',
        'number.required' => 'El campo número es obligatorio.',
        'number.integer' => 'El campo número debe ser un texto.',
        'number.max' => 'El campo número no debe superar los 255 caracteres.',
        'city.required' => 'El campo ciudad es obligatorio.',
        'city.string' => 'El campo ciudad debe ser un texto.',
        'city.max' => 'El campo ciudad no debe superar los 255 caracteres.',

        'floor.string' => 'El campo piso debe ser un texto.',
        'floor.max' => 'El campo piso no debe superar los 255 caracteres.',
        'door.string' => 'El campo puerta debe ser un texto.',
        'door.max' => 'El campo puerta no debe superar los 255 caracteres.',
        'district.string' => 'El campo distrito debe ser un texto.',
        'district.max' => 'El campo distrito no debe superar los 255 caracteres.',
    ];

    public function mount($property = null)
    {
        $this->property = $property;

        if ($property && $property->address) {
            $this->street = $property->address->street;
            $this->number = $property->address->number;
            $this->floor = $property->address->floor;
            $this->door = $property->address->door;
            $this->district = $property->address->district;
            $this->postal_code = $property->address->postal_code;
            $this->city = $property->address->city;
            $this->province = $property->address->province;
            $this->autonomous_community = $property->address->autonomous_community;
            $this->google_map = $property->google_map;
        }

    }


    public function updateLocation()
    {
        $this->validate();
        $this->reset('successMessage', 'errorMessage');

        try {
            $address = $this->property->address;
            $address->update([
                'street' => $this->street,
                'number' => $this->number,
                'floor' => $this->floor,
                'door' => $this->door,
                'district' => $this->district,
                'city' => $this->city,
                'province' => $this->province,
                'autonomous_community' => $this->autonomous_community,
                'postal_code' => $this->postal_code,
            ]);

             // Actualizar enlace de Google Maps
             $this->property->update([
                'google_map' => $this->google_map
            ]);


        $this->successMessage = 'Ubicación actualizada correctamente.';
        $this->errorMessage = '';
        $this->dispatch('location-updated', [
            'type' => 'address',
            'value' => $address->id
        ]);
        } catch (\Exception $e) {
            Log::error("error al actualizar la ubicación: " . $e->getMessage());
            $this->successMessage = '';
            $this->errorMessage = 'Se ha producido un error al actualizar la ubicación.'. $e->getMessage();
        }
    }

    public function updated($propertyName)
    {
    $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.admin.properties.location-form');
    }
}
