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

    // Variables para manejo de idiomas
    public $locale = 'es'; // Idioma por defecto
    public $availableLocales = ['es', 'en', 'fr', 'de'];

    // Mensajes de estado
    public $successMessage = '';
    public $errorMessage = '';

    // Reglas de validación
    protected function rules()
    {
        if ($this->locale === 'es') {
            return [
                'orientation' => 'nullable|string|in:Norte,Sur,Este,Oeste,Noreste,Noroeste,Sureste,Suroeste',
                'exterior_type' => 'nullable|string|in:Exterior,Interior,Mixto',
                'kitchen_type' => 'nullable|string|in:Independiente,Americana,Office,Equipada,Sin equipar',
                'heating_type' => 'nullable|string|in:Individual,Central,Eléctrica,Gas,Gasoil,Sin calefacción',
                'interior_carpentry' => 'nullable|string|in:Aluminio,Madera,PVC,Mixto,Sin carpintería',
                'exterior_carpentry' => 'nullable|string|in:Aluminio,Madera,PVC,Mixto,Sin carpintería',
                'flooring_type' => 'nullable|string|in:Parquet,Tarima,Cerámica,Gres,Terrazo,Mármol,Cemento,Otros',
            ];
        } else {
            // Para otros idiomas no validamos contra una lista específica
            return [
                'orientation' => 'nullable|string',
                'exterior_type' => 'nullable|string',
                'kitchen_type' => 'nullable|string',
                'heating_type' => 'nullable|string',
                'interior_carpentry' => 'nullable|string',
                'exterior_carpentry' => 'nullable|string',
                'flooring_type' => 'nullable|string',
            ];
        }
    }

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

    // Método mount modificado para cargar traducciones
    public function mount(Property $property)
    {
        $this->property = $property;
        $this->loadTranslations();
    }

    // Método para cargar datos según el idioma seleccionado
    public function loadTranslations()
    {
        if ($this->locale === 'es') {
            // Para español, SIEMPRE usamos los valores del modelo principal (tabla properties)
            $this->orientation = $this->property->getRawOriginal('orientation');
            $this->exterior_type = $this->property->getRawOriginal('exterior_type');
            $this->kitchen_type = $this->property->getRawOriginal('kitchen_type');
            $this->heating_type = $this->property->getRawOriginal('heating_type');
            $this->interior_carpentry = $this->property->getRawOriginal('interior_carpentry');
            $this->exterior_carpentry = $this->property->getRawOriginal('exterior_carpentry');
            $this->flooring_type = $this->property->getRawOriginal('flooring_type');

        } else {
            // Para otros idiomas, buscamos la traducción
            $translation = PropertyTranslation::where('property_id', $this->property->id)
                ->where('locale', $this->locale)
                ->first();

            if ($translation) {
                $this->orientation = $translation->orientation ?? $this->property->orientation;
                $this->exterior_type = $translation->exterior_type ?? $this->property->exterior_type;
                $this->kitchen_type = $translation->kitchen_type ?? $this->property->kitchen_type;
                $this->heating_type = $translation->heating_type ?? $this->property->heating_type;
                $this->interior_carpentry = $translation->interior_carpentry ?? $this->property->interior_carpentry;
                $this->exterior_carpentry = $translation->exterior_carpentry ?? $this->property->exterior_carpentry;
                $this->flooring_type = $translation->flooring_type ?? $this->property->flooring_type;
            } else {
                // Si no hay traducción, usar los valores predeterminados
                $this->orientation = $this->property->orientation;
                $this->exterior_type = $this->property->exterior_type;
                $this->kitchen_type = $this->property->kitchen_type;
                $this->heating_type = $this->property->heating_type;
                $this->interior_carpentry = $this->property->interior_carpentry;
                $this->exterior_carpentry = $this->property->exterior_carpentry;
                $this->flooring_type = $this->property->flooring_type;
            }
        }
    }

    // Método para cambiar el idioma
    public function changeLocale($locale)
    {
        $this->locale = $locale;
        $this->loadTranslations();
    }

    // Método render modificado para pasar los idiomas disponibles
    public function render()
    {
        return view('livewire.admin.properties.additional-features-form', [
            'availableLocales' => $this->availableLocales,
        ]);
    }

    // Método updateAdditionalFeatures modificado
    public function updateAdditionalFeatures()
    {
        $this->validate();

        try {
            if ($this->locale === 'es') {
                // Actualizar el modelo principal solo si estamos en español
                $this->property->update([
                    'orientation' => $this->orientation,
                    'exterior_type' => $this->exterior_type,
                    'kitchen_type' => $this->kitchen_type,
                    'heating_type' => $this->heating_type,
                    'interior_carpentry' => $this->interior_carpentry,
                    'exterior_carpentry' => $this->exterior_carpentry,
                    'flooring_type' => $this->flooring_type,
                ]);

                // Generar traducciones automáticas para otros idiomas
                $this->updateTranslations();

                $this->successMessage = 'Características adicionales actualizadas correctamente.';
            } else {
                // Actualizar solo la traducción para el idioma actual
                $this->updateSingleTranslation($this->locale);
                $this->successMessage = 'Traducción actualizada correctamente.';
            }

            $this->errorMessage = '';
            $this->dispatch('additional-features-updated');
        } catch (\Exception $e) {
            Log::error('Error al actualizar las características adicionales', [
                'property_id' => $this->property->id,
                'locale' => $this->locale,
                'error' => $e->getMessage(),
            ]);

            $this->errorMessage = 'Error al actualizar las características adicionales. Por favor, intente nuevamente.';
            $this->successMessage = '';
        }
    }

    // Método para actualizar una traducción específica
    private function updateSingleTranslation($locale)
    {
        $translationData = [
            'orientation' => $this->orientation,
            'exterior_type' => $this->exterior_type,
            'kitchen_type' => $this->kitchen_type,
            'heating_type' => $this->heating_type,
            'interior_carpentry' => $this->interior_carpentry,
            'exterior_carpentry' => $this->exterior_carpentry,
            'flooring_type' => $this->flooring_type,
        ];

        PropertyTranslation::updateOrCreate(
            ['property_id' => $this->property->id, 'locale' => $locale],
            $translationData
        );
    }

    // Método updateTranslations modificado
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
