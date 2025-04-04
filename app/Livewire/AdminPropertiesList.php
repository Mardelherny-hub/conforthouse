<?php

namespace App\Livewire;

use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminPropertiesList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $filters = [
        'status' => '',
        'property_type' => '',
        'min_price' => null,
        'max_price' => null,
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 10],
        'filters' => ['except' => [
            'status' => '',
            'property_type' => '',
            'min_price' => null,
            'max_price' => null,
        ]],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilters()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        // Mapeo de campos de ordenamiento para relaciones
        $fieldMapping = [
            'status' => 'status_id',
            'property_type' => 'property_type_id',
        ];

        // Si el campo está en el mapeo, usar el campo real de la BD
        $actualField = $fieldMapping[$field] ?? $field;

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field; // Mantener el campo original para la interfaz
    }

    public function resetFilters()
    {
        $this->reset('search', 'filters');
    }

    public function deleteProperty($id)
    {
        $property = Property::findOrFail($id);

        // Eliminar imágenes asociadas a la propiedad
        if ($property->image) {
            Storage::delete('public/properties/' . $property->image);
        }

        $property->delete();
        session()->flash('message', 'Propiedad eliminada correctamente.');
    }

    public function toggleFeatured($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        $property->is_featured = !$property->is_featured;
        $property->save();

        session()->flash('message', 'Estado de propiedad destacada actualizado.');
    }


    public function render()
    {
        Log::info('Filter values:', [
            'status' => $this->filters['status'],
            'property_type' => $this->filters['property_type'],
            'min_price' => $this->filters['min_price'],
            'max_price' => $this->filters['max_price'],
        ]);

        // Mapeo de campos para ordenamiento
        $orderByField = $this->sortField;
        if ($this->sortField === 'status') {
            $orderByField = 'status_id';
        } elseif ($this->sortField === 'property_type') {
            $orderByField = 'property_type_id';
        }

        // Normalizar valor de property_type (convertir a minúsculas para comparación insensible a mayúsculas)
        $propertyTypeFilter = is_string($this->filters['property_type']) ?
            strtolower($this->filters['property_type']) : $this->filters['property_type'];

        // Normalizar valor de status
        $statusFilter = is_string($this->filters['status']) ?
            strtolower($this->filters['status']) : $this->filters['status'];

        $properties = Property::query()
            ->with(['propertyType', 'status', 'address.city', 'images'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('reference', 'like', '%' . $this->search . '%')
                    ->orWhereHas('address', function($addressQuery) {
                        $addressQuery->where('street', 'like', '%' . $this->search . '%')
                                    ->orWhere('number', 'like', '%' . $this->search . '%')
                                    ->orWhere('postal_code', 'like', '%' . $this->search . '%')
                                    ->orWhere('city', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($statusFilter, function ($query) use ($statusFilter) {
                // Para búsqueda por nombre (insensible a mayúsculas/minúsculas)
                $query->whereHas('status', function($statusQuery) use ($statusFilter) {
                    $statusQuery->whereRaw('LOWER(name) LIKE ?', ['%' . $statusFilter . '%']);
                });
            })
            ->when($propertyTypeFilter, function ($query) use ($propertyTypeFilter) {
                // Para búsqueda por nombre (insensible a mayúsculas/minúsculas)
                $query->whereHas('propertyType', function($typeQuery) use ($propertyTypeFilter) {
                    $typeQuery->whereRaw('LOWER(name) LIKE ?', ['%' . $propertyTypeFilter . '%']);
                });
            })
            ->when($this->filters['min_price'], function ($query) {
                $query->where('price', '>=', $this->filters['min_price']);
            })
            ->when($this->filters['max_price'], function ($query) {
                $query->where('price', '<=', $this->filters['max_price']);
            })
            ->orderBy($orderByField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin-properties-list', [
            'properties' => $properties,
        ]);
    }
}
