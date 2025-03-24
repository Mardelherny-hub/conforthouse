<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AutonomousCommunity;
use App\Models\Province;
use App\Models\City;

class LocationSelector extends Component
{
    public $autonomous_community_id;
    public $province_id;
    public $city_id;

    public $autonomousCommunities;
    public $provinces = [];
    public $cities = [];
    public $isEdit = false;

    public function mount($selectedCity = null)
    {
        $this->autonomousCommunities = AutonomousCommunity::all();

        if ($selectedCity) {
            $this->isEdit = true;
            $this->city_id = $selectedCity;

            // Obtenemos la ciudad con sus relaciones
            $city = City::with(['province.autonomousCommunity'])->find($selectedCity);

            if ($city) {
                // Establecemos los IDs de provincia y comunidad autónoma
                $this->province_id = $city->province_id;
                $this->autonomous_community_id = $city->province->autonomous_community_id;

                // Cargamos las provincias de la comunidad seleccionada
                $this->provinces = Province::where('autonomous_community_id', $this->autonomous_community_id)->get();

                // Cargamos las ciudades de la provincia seleccionada
                $this->cities = City::where('province_id', $this->province_id)->get();
            }
        }
    }

    public function updatedProvinceId($value)
    {
        if ($value) {
            $this->cities = City::where('province_id', $value)->get();
        } else {
            $this->cities = [];
        }
        $this->city_id = null;
        $this->dispatch('location-updated', [
            'type' => 'province',
            'value' => $value
        ]);
    }

    public function updatedCityId($value)
    {
        $this->dispatch('location-updated', [
            'type' => 'city',
            'value' => $value
        ]);
    }

    public function getSelectedLocationDataProperty()
    {
        if ($this->city_id) {
            $city = City::with(['province.autonomousCommunity'])->find($this->city_id);
            return [
                'city' => $city->name,
                'province' => $city->province->name,
                'community' => $city->province->autonomousCommunity->name
            ];
        }
        return null;
    }

    public function render()
    {
        return view('livewire.location-selector');
    }
}
