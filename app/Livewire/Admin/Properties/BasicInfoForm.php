<?php

namespace App\Livewire\Admin\Properties;

use App\Models\Operation;
use App\Models\OperationTranslation;
use App\Models\Property;
use App\Models\PropertyTranslation;
use App\Models\PropertyType;
use App\Models\PropertyTypeTranslation;
use App\Models\Status;
use App\Helpers\LibreTranslateHelper;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class BasicInfoForm extends Component
{
    public Property $property;
    public $reference;
    public $operation_id;
    public $property_type_id;
    public $status_id;
    public $title;
    public $description;
    public $meta_description;

    // Variables para manejo de idiomas
    public $locale = 'es'; // Idioma por defecto
    public $availableLocales = ['es', 'en', 'fr', 'de'];

    // Para mensajes de éxito o error
    public $successMessage = '';
    public $errorMessage = '';

    // Reglas de validación
    protected function rules()
    {
        $rules = [
            'reference' => 'required|string|max:255',
            'operation_id' => 'required|exists:operations,id',
            'property_type_id' => 'required|exists:property_types,id',
            'status_id' => 'required|exists:statuses,id',
        ];

        // Solo validamos los campos traducibles cuando estamos en español
        if ($this->locale === 'es') {
            $rules['title'] = 'required|string|max:255';
            $rules['description'] = 'required|string';
            $rules['meta_description'] = 'nullable|string|max:500';
        } else {
            $rules['title'] = 'nullable|string|max:255';
            $rules['description'] = 'nullable|string';
            $rules['meta_description'] = 'nullable|string|max:500';
        }

        return $rules;
    }

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
        $this->loadTranslations();
    }

    // Método para cargar datos según el idioma seleccionado
    public function loadTranslations()
    {

         // Para campos básicos que no requieren traducción
        $this->reference = $this->property->reference;
        $this->operation_id = $this->property->operation_id;
        $this->property_type_id = $this->property->property_type_id;
        $this->status_id = $this->property->status_id;

        if ($this->locale === 'es') {
            // Para español, usamos los valores del modelo principal
            $this->title = $this->property->getRawOriginal('title');
            $this->description = $this->property->getRawOriginal('description');
            $this->meta_description = $this->property->getRawOriginal('meta_description');
        } else {
            // Para otros idiomas, buscamos la traducción
            $translation = PropertyTranslation::where('property_id', $this->property->id)
                ->where('locale', $this->locale)
                ->first();

            // Buscar la traducción de la operación
            $operationTranslation = OperationTranslation::where('operation_id', $this->property->operation_id)
                ->where('locale', $this->locale)
                ->first();
            // buscar la traducción para tipo de propiedad
            $propertyTypeTranslation = PropertyTypeTranslation::where('property_type_id', $this->property->property_type_id)
                ->where('locale', $this->locale)
                ->first();

            // Asignar operation_id (siempre el ID, no el nombre traducido)
            $this->operation_id = $this->property->operation_id;
            // Asignar property_type_id (siempre el ID, no el nombre traducido)
            $this->property_type_id = $this->property->property_type_id;
            // Asignar status_id (siempre el ID, no el nombre traducido)
            $this->status_id = $this->property->status_id;


            if ($translation) {
                $this->title = $translation->title;
                $this->description = $translation->description;
                $this->meta_description = $translation->meta_description;
            } else {
                // Si no hay traducción, usamos los valores del modelo principal
                // Es mejor mostrar el contenido en español que dejar campos vacíos
                $this->title = $this->property->getRawOriginal('title');
                $this->description = $this->property->getRawOriginal('description');
                $this->meta_description = $this->property->getRawOriginal('meta_description');
            }
        }
    }

    public function changeLocale($locale)
    {
        $this->locale = $locale;

        // Recargar la propiedad con sus traducciones
        $this->property = Property::with(['translations' => function($query) use ($locale) {
            $query->where('locale', $locale);
        }])->find($this->property->id);

        // Limpiar los campos antes de recargar
        $this->reset(['title', 'description', 'meta_description']);

        // Cargar las traducciones actualizadas
        $this->loadTranslations();

        $this->reset(['successMessage', 'errorMessage']);
        $this->resetValidation();


    }

    public function render()
    {
        return view('livewire.admin.properties.basic-info-form', [
            'operations' => Operation::orderBy('name')->get(),
            'propertyTypes' => PropertyType::orderBy('name')->get(),
            'statuses' => Status::orderBy('name')->get(),
            'availableLocales' => $this->availableLocales,
            'property' => $this->property,
        ]);
    }

    public function updateBasicInfo()
    {
        $this->validate();
        $this->reset('successMessage', 'errorMessage');

        try {
            if ($this->locale === 'es') {
                // Actualizar la propiedad principal solo si estamos en español
                $this->property->update([
                    'reference' => $this->reference,
                    'operation_id' => $this->operation_id,
                    'property_type_id' => $this->property_type_id,
                    'status_id' => $this->status_id,
                    'title' => $this->title,
                    'description' => $this->description,
                    'meta_description' => $this->meta_description,
                ]);

                // Generar traducciones automáticas para otros idiomas
                $this->updateTranslations();

                $this->successMessage = 'Información básica actualizada correctamente.';
            } else {
                // Actualizar solo los campos no traducibles
                $this->property->update([
                    'reference' => $this->reference,
                    'operation_id' => $this->operation_id,
                    'property_type_id' => $this->property_type_id,
                    'status_id' => $this->status_id,
                ]);

                // Actualizar solo la traducción para el idioma actual
                $this->updateSingleTranslation($this->locale);
                $this->successMessage = 'Traducción actualizada correctamente.';
            }

            // Recargar la propiedad y sus traducciones
            $this->property = Property::with('translations')->find($this->property->id);

            // Recargar las traducciones para el idioma actual
            $this->loadTranslations();

            $this->errorMessage = '';
            $this->dispatch('basic-info-updated');

        } catch (\Exception $e) {
            Log::error('Error al actualizar información básica: ' . $e->getMessage());
            $this->errorMessage = 'Error al actualizar la información básica. Por favor, intente nuevamente.';
            $this->successMessage = '';
        }
    }

    // Método para actualizar una traducción específica
    private function updateSingleTranslation($locale)
    {
        $translationData = [
            'title' => $this->title,
            'description' => $this->description,
            'meta_description' => $this->meta_description,
        ];

        PropertyTranslation::updateOrCreate(
            ['property_id' => $this->property->id, 'locale' => $locale],
            $translationData
        );
    }

    private function updateTranslations()
    {
        // Campos que necesitan traducción en esta sección
        $fieldsToTranslate = [
            'title' => $this->title,
            'description' => $this->description,
            'meta_description' => $this->meta_description,
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
