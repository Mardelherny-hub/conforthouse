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

    // New property to prevent multiple dispatches
    public $preventDispatch = false;

    protected $listeners = [
        'resetLocationSelector' => 'resetSelector'
    ];

    public function mount($selectedCity = null)
    {
        $this->autonomousCommunities = AutonomousCommunity::all();

        if ($selectedCity) {
            $this->isEdit = true;
            $this->city_id = $selectedCity;

            $city = City::with(['province.autonomousCommunity'])->find($selectedCity);

            if ($city) {
                $this->province_id = $city->province_id;
                $this->autonomous_community_id = $city->province->autonomous_community_id;

                $this->provinces = Province::where('autonomous_community_id', $this->autonomous_community_id)->get();
                $this->cities = City::where('province_id', $this->province_id)->get();
            }
        }
    }

    public function updatedAutonomousCommunityId($value)
    {
        $this->provinces = $value
            ? Province::where('autonomous_community_id', $value)->get()
            : [];

        $this->cities = [];
        $this->province_id = null;
        $this->city_id = null;

        $this->dispatchLocationEvent('autonomous_community', $value);
    }

    public function updatedProvinceId($value)
    {
        $this->cities = $value
            ? City::where('province_id', $value)->get()
            : [];

        $this->city_id = null;

        $this->dispatchLocationEvent('province', $value);
    }

    public function updatedCityId($value)
    {
        $this->dispatchLocationEvent('city', $value);
    }

    private function dispatchLocationEvent($type, $value)
    {
        if (!$this->preventDispatch) {
            $this->dispatch('location-updated', [
                'type' => $type,
                'value' => $value
            ])->to('admin.properties.location-form');
        }
    }

    public function resetSelector()
    {
        $this->autonomous_community_id = null;
        $this->province_id = null;
        $this->city_id = null;
        $this->provinces = [];
        $this->cities = [];
        $this->isEdit = false;
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
