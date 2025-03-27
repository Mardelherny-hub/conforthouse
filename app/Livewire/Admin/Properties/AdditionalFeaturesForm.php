<?php

namespace App\Livewire\Admin\Properties;

use Livewire\Component;
use App\Models\Property;
use App\Models\PropertyTranslation;
use App\Helpers\LibreTranslateHelper;
use Illuminate\Support\Facades\Log;

class AdditionalFeaturesForm extends Component
{
    public Property $property;

    // Campos añadidos
    public $orientation;
    public $exterior_type;
    public $kitchen_type;
    public $heating_type;
    public $interior_carpentry;
    public $exterior_carpentry;
    public $flooring_type;

    // Mensajes de estado
    public $successMessage = '';
    public $errorMessage = '';

    // Reglas de validación
    protected $rules = [
        'orientation' => 'nullable|string|in:Norte,Sur,Este,Oeste,Noreste,Noroeste,Sureste,Suroeste',
        'exterior_type' => 'nullable|string|in:Exterior,Interior,Mixto',
        'kitchen_type' => 'nullable|string|in:Independiente,Americana,Office,Equipada,Sin equipar',
        'heating_type' => 'nullable|string|in:Individual,Central,Eléctrica,Gas,Gasoil,Sin calefacción',
        'interior_carpentry' => 'nullable|string|in:Aluminio,Madera,PVC,Mixto,Sin carpintería',
        'exterior_carpentry' => 'nullable|string|in:Aluminio,Madera,PVC,Mixto,Sin carpintería',
        'flooring_type' => 'nullable|string|in:Parquet,Tarima,Cerámica,Gres,Terrazo,Mármol,Cemento,Otros',
    ];

    // Mensajes de error personalizados
    protected $messages = [
        'orientation.in' => 'La orientación seleccionada no es válida.',
        'exterior_type.in' => 'El tipo de exterior seleccionado no es válido.',
        'kitchen_type.in' => 'El tipo de cocina seleccionado no es válido.',
        'heating_type.in' => 'El tipo de calefacción seleccionado no es válido.',
        'interior_carpentry.in' => 'El tipo de carpintería interior seleccionado no es válido.',
        'exterior_carpentry.in' => 'El tipo de carpintería exterior seleccionado no es válido.',
        'flooring_type.in' => 'El tipo de suelo seleccionado no es válido.',
    ];

    // Método mount (igual que antes)
    public function mount(Property $property)
    {
        $this->property = $property;
        $this->orientation = $property->orientation;
        $this->exterior_type = $property->exterior_type;
        $this->kitchen_type = $property->kitchen_type;
        $this->heating_type = $property->heating_type;
        $this->interior_carpentry = $property->interior_carpentry;
        $this->exterior_carpentry = $property->exterior_carpentry;
        $this->flooring_type = $property->flooring_type;
    }

    // Método render (igual que antes)
    public function render()
    {
        return view('livewire.admin.properties.additional-features-form');
    }

    // Método updatedAdditionalFeatures (igual que antes)
    public function updateAdditionalFeatures()
    {
        $this->validate();

        try {
            $this->property->update([
                'orientation' => $this->orientation,
                'exterior_type' => $this->exterior_type,
                'kitchen_type' => $this->kitchen_type,
                'heating_type' => $this->heating_type,
                'interior_carpentry' => $this->interior_carpentry,
                'exterior_carpentry' => $this->exterior_carpentry,
                'flooring_type' => $this->flooring_type,
            ]);

            $this->updateTranslations();

            $this->successMessage = 'Características adicionales actualizadas correctamente.';
            $this->errorMessage = '';

            $this->dispatch('additional-features-updated');
        } catch (\Exception $e) {
            Log::error('Error al actualizar las características adicionales', [
                'property_id' => $this->property->id,
                'error' => $e->getMessage(),
            ]);

            $this->errorMessage = 'Error al actualizar las características adicionales. Por favor, intente nuevamente.';
            $this->successMessage = '';
        }
    }

    // Método updateTranslations (igual que antes)
    private function updateTranslations()
    {
        // Campos que necesitan traducción en esta sección
        $fieldsToTranslate = [
            'orientation' => $this->orientation,
            'exterior_type' => $this->exterior_type,
            'kitchen_type' => $this->kitchen_type,
            'heating_type' => $this->heating_type,
            'interior_carpentry' => $this->interior_carpentry,
            'exterior_carpentry' => $this->exterior_carpentry,
            'flooring_type' => $this->flooring_type,
        ];

        // Idiomas a traducir
        $languages = ['en', 'fr', 'de'];

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
