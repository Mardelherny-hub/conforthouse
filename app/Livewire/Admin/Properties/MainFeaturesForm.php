<?php

namespace App\Livewire\Admin\Properties;

use App\Models\Property;
use App\Models\PropertyTranslation;
use App\Helpers\LibreTranslateHelper;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class MainFeaturesForm extends Component
{
    public $property;
    public $price;
    public $community_expenses;
    public $built_area;
    public $condition;
    public $rooms;
    public $bathrooms;
    public $year_built;
    public $parking_spaces;
    public $floors;
    public $floor;
    public $isloading = false;
    // Para mensajes de éxito o error
    public $successMessage = '';
    public $errorMessage = '';

    protected $rules = [
        'price' => 'required|numeric|min:0',
        'community_expenses' => 'nullable|numeric|min:0',
        'built_area' => 'required|numeric|min:0',
        'condition' => 'nullable|string|max:255',
        'rooms' => 'required|integer|min:0',
        'bathrooms' => 'required|integer|min:0',
        'year_built' => 'nullable|integer|min:1800|max:2100',
        'parking_spaces' => 'nullable|integer|min:0',
        'floors' => 'nullable|integer|min:0',
        'floor' => 'nullable|integer|min:0',
    ];

    protected $messages = [
        'price.required' => 'El precio es obligatorio.',
        'price.numeric' => 'El precio debe ser un valor numérico.',
        'price.min' => 'El precio debe ser mayor o igual a 0.',
        'community_expenses.numeric' => 'Los gastos de comunidad deben ser un valor numérico.',
        'community_expenses.min' => 'Los gastos de comunidad deben ser mayor o igual a 0.',
        'built_area.required' => 'La superficie construida es obligatoria.',
        'built_area.numeric' => 'La superficie construida debe ser un valor numérico.',
        'built_area.min' => 'La superficie construida debe ser mayor o igual a 0.',
        'rooms.required' => 'El número de habitaciones es obligatorio.',
        'rooms.integer' => 'El número de habitaciones debe ser un número entero.',
        'rooms.min' => 'El número de habitaciones debe ser mayor o igual a 0.',
        'bathrooms.required' => 'El número de baños es obligatorio.',
        'bathrooms.integer' => 'El número de baños debe ser un número entero.',
        'bathrooms.min' => 'El número de baños debe ser mayor o igual a 0.',
        'year_built.integer' => 'El año de construcción debe ser un número entero.',
        'year_built.min' => 'El año de construcción debe ser mayor o igual a 1800.',
        'year_built.max' => 'El año de construcción debe ser menor o igual a 2100.',
        'parking_spaces.integer' => 'El número de plazas de parking debe ser un número entero.',
        'parking_spaces.min' => 'El número de plazas de parking debe ser mayor o igual a 0.',
        'floors.integer' => 'El número de plantas debe ser un número entero.',
        'floors.min' => 'El número de plantas debe ser mayor o igual a 0.',
        'floor.integer' => 'El piso debe ser un número entero.',
        'floor.min' => 'El piso debe ser mayor o igual a 0.',
    ];

    public function mount(Property $property)
    {
        $this->property = $property;
        $this->price = $property->price;
        $this->community_expenses = $property->community_expenses;
        $this->built_area = $property->built_area;
        $this->condition = $property->condition;
        $this->rooms = $property->rooms;
        $this->bathrooms = $property->bathrooms;
        $this->year_built = $property->year_built;
        $this->parking_spaces = $property->parking_spaces;
        $this->floors = $property->floors;
        $this->floor = $property->floor;
    }

    public function render()
    {
        return view('livewire.admin.properties.main-features-form');
    }

    public function updateMainFeatures()
    {
        $this->validate();

        try {
            // Actualizar la propiedad
            $this->property->update([
                'price' => $this->price,
                'community_expenses' => $this->community_expenses,
                'built_area' => $this->built_area,
                'condition' => $this->condition,
                'rooms' => $this->rooms,
                'bathrooms' => $this->bathrooms,
                'year_built' => $this->year_built,
                'parking_spaces' => $this->parking_spaces,
                'floors' => $this->floors,
                'floor' => $this->floor,
            ]);

            // Actualizar las traducciones
            $this->updateTranslations();

            $this->successMessage = 'Características principales actualizadas correctamente.';
            $this->errorMessage = '';

            $this->dispatch('main-features-updated');
        } catch (\Exception $e) {
            Log::error('Error al actualizar características principales: ' . $e->getMessage());
            $this->errorMessage = 'Error al actualizar las características principales. Por favor, intente nuevamente.';
            $this->successMessage = '';
        }
    }

    private function updateTranslations()
    {
        // Campos que necesitan traducción en esta sección
        $fieldsToTranslate = [
            'condition' => $this->condition,
        ];

        // Idiomas a traducir
        $languages = ['en', 'fr', 'de', 'nl'];

        foreach ($languages as $lang) {
            // Buscar si ya existe una traducción para este idioma
            $translation = PropertyTranslation::where('property_id', $this->property->id)
                ->where('locale', $lang)
                ->first();

            $translationData = [];

            foreach ($fieldsToTranslate as $field => $value) {
                if (!empty($value)) {
                    try {
                        $translatedText = LibreTranslateHelper::translate($value, 'es', $lang);
                        $translationData[$field] = $translatedText;
                    } catch (\Exception $e) {
                        Log::error("Error al traducir campo: $field", [
                            'lang' => $lang,
                            'error' => $e->getMessage(),
                            'property_id' => $this->property->id
                        ]);
                        // Si falla la traducción, usar el texto original
                        $translationData[$field] = $value;
                    }
                }
            }

            if ($translation) {
                // Actualizar traducción existente
                $translation->update($translationData);
            } else {
                // Crear nueva traducción si no existe
                $translationData['property_id'] = $this->property->id;
                $translationData['locale'] = $lang;
                PropertyTranslation::create($translationData);
            }
        }
    }
}
