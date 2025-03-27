<?php

namespace App\Livewire\Admin\Properties;

use App\Models\Operation;
use App\Models\Property;
use App\Models\PropertyTranslation;
use App\Models\PropertyType;
use App\Models\Status;
use App\Helpers\LibreTranslateHelper;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class BasicInfoForm extends Component
{
    public $property;
    public $reference;
    public $operation_id;
    public $property_type_id;
    public $status_id;
    public $title;
    public $meta_description;

    // Para mensajes de éxito o error
    public $successMessage = '';
    public $errorMessage = '';


    protected $rules = [
        'reference' => 'required|string|max:255',
        'operation_id' => 'required|exists:operations,id',
        'property_type_id' => 'required|exists:property_types,id',
        'status_id' => 'required|exists:statuses,id',
        'title' => 'required|string|max:255',
        'meta_description' => 'nullable|string|max:500',
    ];

    protected $messages = [
        'reference.required' => 'La referencia es obligatoria.',
        'operation_id.required' => 'Debe seleccionar una operación.',
        'operation_id.exists' => 'La operación seleccionada no es válida.',
        'property_type_id.required' => 'Debe seleccionar un tipo de propiedad.',
        'property_type_id.exists' => 'El tipo de propiedad seleccionado no es válido.',
        'status_id.required' => 'Debe seleccionar un estado.',
        'status_id.exists' => 'El estado seleccionado no es válido.',
        'title.required' => 'El título es obligatorio.',
    ];

    public function mount(Property $property)
    {
        $this->property = $property;
        $this->reference = $property->reference;
        $this->operation_id = $property->operation_id;
        $this->property_type_id = $property->property_type_id;
        $this->status_id = $property->status_id;
        $this->title = $property->title;
        $this->meta_description = $property->meta_description;
    }

    public function render()
    {
        return view('livewire.admin.properties.basic-info-form', [
            'operations' => Operation::orderBy('name')->get(),
            'propertyTypes' => PropertyType::orderBy('name')->get(),
            'statuses' => Status::orderBy('name')->get(),
        ]);
    }

    public function updateBasicInfo()
    {
        $this->validate();
        $this->reset('successMessage', 'errorMessage');

        try {
            // Actualizar la propiedad
            $this->property->update([
                'reference' => $this->reference,
                'operation_id' => $this->operation_id,
                'property_type_id' => $this->property_type_id,
                'status_id' => $this->status_id,
                'title' => $this->title,
                'meta_description' => $this->meta_description,
            ]);

            // Actualizar las traducciones
            $this->updateTranslations();

            $this->successMessage = 'Información básica actualizada correctamente.';
            $this->errorMessage = '';

            $this->dispatch('basic-info-updated');

        } catch (\Exception $e) {
            Log::error('Error al actualizar información básica: ' . $e->getMessage());
            $this->errorMessage = 'Error al actualizar la información básica. Por favor, intente nuevamente.';
        }
    }

    private function updateTranslations()
    {
        // Campos que necesitan traducción en esta sección
        $fieldsToTranslate = [
            'title' => $this->title,
            'meta_description' => $this->meta_description,
        ];

        // Idiomas a traducir
        $languages = ['en', 'fr', 'de'];

         // Obtener todas las traducciones existentes en una sola consulta
        $translations = PropertyTranslation::where('property_id', $this->property->id)
        ->whereIn('locale', $languages)
        ->get()
        ->keyBy('locale');
        foreach ($languages as $lang) {


            $translationData = [];

            foreach ($fieldsToTranslate as $field => $value) {
                if (!empty($value)) {
                    try {
                        $translationData[$field] = LibreTranslateHelper::translate($value, 'es', $lang);
                    } catch (\Exception $e) {
                        Log::error("Error al traducir campo: $field", [
                            'lang' => $lang,
                            'error' => $e->getMessage(),
                            'property_id' => $this->property->id
                        ]);
                        $translationData[$field] = $value;
                    }
                }
            }

            if ($translations->has($lang)) {
                // Actualizar traducción existente
                $translations[$lang]->update($translationData);
            } else {
                // Crear nueva traducción
                PropertyTranslation::create(array_merge($translationData, [
                    'property_id' => $this->property->id,
                    'locale' => $lang
                ]));
            }
        }
    }
}
