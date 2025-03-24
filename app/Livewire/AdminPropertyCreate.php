<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Operation;
use App\Models\PropertyType;
use App\Models\Status;
use App\Models\Property;
use App\Models\Address;
use App\Models\City;
use App\Models\Province;
use App\Models\AutonomousCommunity;
use App\Models\PropertyImage;
use App\Helpers\LibreTranslateHelper;
use App\Models\PropertyTranslation;
use Illuminate\Support\Facades\Log;


class AdminPropertyCreate extends Component
{
    use WithFileUploads;

    // Control de pasos
    public $step = 1;
    public $totalSteps = 4;

    // Información básica
    public $reference;
    public $operation_id;
    public $property_type_id;
    public $status_id;
    public $title;
    public $meta_description;
    public $description;

    // Precios y detalles económicos
    public $price;
    public $community_expenses;

    // Características
    public $built_area;
    public $condition;
    public $rooms;
    public $bathrooms;
    public $year_built;
    public $parking_spaces;
    public $floors;

    // Características adicionales
    public $orientation;
    public $exterior_type;
    public $kitchen_type;
    public $heating_type;
    public $interior_carpentry;
    public $exterior_carpentry;
    public $flooring_type;
    public $views;
    public $distance_to_sea;
    public $regime;
    public $google_map;

    // Ubicación
    public $autonomous_community_id;
    public $province_id;
    public $city_id;
    public $district;
    public $street;
    public $number;
    public $floor; // Nueva propiedad
    public $door; // Nueva propiedad
    public $postal_code;

    // Propiedades para almacenar las opciones disponibles
    public $provinces = [];
    public $cities = [];

    // Fotos
    public $photos = [];
    public $tempPhotos = []; // Para almacenar temporalmente las fotos subidas


    // Opciones para selects
    public $orientationOptions = ['Norte', 'Sur', 'Este', 'Oeste', 'Noreste', 'Noroeste', 'Sureste', 'Suroeste'];
    public $exteriorOptions = ['Exterior', 'Interior', 'Mixto'];
    public $kitchenOptions = ['Independiente', 'Americana', 'Office'];
    public $heatingOptions = ['Individual', 'Central', 'Eléctrica', 'Gas', 'No tiene'];
    public $carpentryOptions = ['Madera', 'Aluminio', 'PVC'];
    public $flooringOptions = ['Parquet', 'Cerámica', 'Mármol', 'Tarima', 'Gres'];
    public $conditionOptions = ['Nuevo', 'A estrenar', 'Buen estado', 'A reformar', 'Reformado'];

    public function mount()
    {
        if ($this->autonomous_community_id) {
            $this->provinces = Province::where('autonomous_community_id', $this->autonomous_community_id)
                ->orderBy('name')
                ->get();

            if ($this->province_id) {
                $this->cities = City::where('province_id', $this->province_id)
                    ->orderBy('name')
                    ->get();
            }
        }
    }

    public function render()
    {
        return view('livewire.admin-property-create', [
            'operations' => Operation::all(),
            'propertyTypes' => PropertyType::all(),
            'statuses' => Status::all(),
            'autonomousCommunities' => AutonomousCommunity::all(),
            // Usa las propiedades que ya has cargado en los métodos updated*
            'provinces' => $this->provinces,
            'cities' => $this->cities,
        ]);
    }

    public function nextStep()
    {
        $this->validateStep();
        if ($this->step < $this->totalSteps) {
            $this->step++;
        }
    }

    public function prevStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function validateStep()
    {
        $rules = [];

        if ($this->step == 1) {
            $rules = [
                'reference' => 'required|unique:properties,reference',
                'operation_id' => 'required',
                'property_type_id' => 'required',
                'status_id' => 'required',
                'title' => 'required|min:5',
                'meta_description' => 'required|min:10|max:160',
                'description' => 'required|min:50',
                'price' => 'required|numeric|min:1',
                'community_expenses' => 'nullable|numeric|min:0',
            ];
        } elseif ($this->step == 2) {
            $rules = [
                'autonomous_community_id' => 'required',
                'province_id' => 'required',
                'city_id' => 'required',
                'street' => 'required',
                'number' => 'required',
                'postal_code' => 'nullable', // Cambiado a nullable ya que mencionaste que no es requerido
                'district' => 'nullable', // Añadido district como nullable
                'floor' => 'nullable', // Añadido floor como nullable
                'door' => 'nullable', // Añadido door como nullable
                'google_map' => 'nullable|url',
            ];
        } elseif ($this->step == 3) {
            $rules = [
                'built_area' => 'required|numeric|min:1',
                'condition' => 'required',
                'rooms' => 'required|integer|min:0',
                'bathrooms' => 'required|integer|min:0',
                'year_built' => 'nullable|integer|min:1900|max:' . date('Y'),
                // El resto de campos pueden ser opcionales
            ];
        } elseif ($this->step == 4) {
            $rules = [
                'photos.*' => 'image|max:2048', // Máximo 2MB por imagen
            ];
        }


        $this->validate($rules);

        // Si estamos en el paso de fotos y se validó correctamente,
        // mover las fotos a tempPhotos para mostrarlas
        if ($this->step == 4 && !empty($this->photos)) {
            foreach ($this->photos as $photo) {
                $this->tempPhotos[] = $photo;
            }
            $this->photos = []; // Limpiar el array de fotos después de procesarlas

            // Re-renderizar el componente para mostrar las imágenes
            $this->dispatchBrowserEvent('photos-updated');
        }
    }

    // Métodos para actualizar dependencias en cascada
    public function updatedAutonomousCommunityId()
    {
        $this->province_id = null;
        $this->city_id = null;

        // Cargar provincias que pertenecen a la comunidad autónoma seleccionada
        if ($this->autonomous_community_id) {
            $this->provinces = Province::where('autonomous_community_id', $this->autonomous_community_id)
                ->orderBy('name')
                ->get();
        } else {
            $this->provinces = [];
        }

        // Limpiar ciudades ya que no hay provincia seleccionada
        $this->cities = [];
    }

    public function updatedProvinceId()
    {
        $this->city_id = null;

        // Cargar ciudades que pertenecen a la provincia seleccionada
        if ($this->province_id) {
            $this->cities = City::where('province_id', $this->province_id)
                ->orderBy('name')
                ->get();
        } else {
            $this->cities = [];
        }
    }

    // Método para actualizar imágenes (wire:model)
    public function updatedPhotos()
    {
        if (!empty($this->photos)) {
            $this->validate([
                'photos.*' => 'image|max:2048',
            ]);

            foreach ($this->photos as $photo) {
                $this->tempPhotos[] = $photo;
            }

            $this->photos = []; // Limpiar el array de fotos después de procesarlas
        }
    }

    // Añade este método para manejar la limpieza completa de fotos
    public function clearAllPhotos()
    {
        $this->tempPhotos = [];
        $this->photos = [];
    }

    // Método para eliminar una foto temporal
    public function removePhoto($index)
    {
        if (isset($this->tempPhotos[$index])) {
            unset($this->tempPhotos[$index]);
            $this->tempPhotos = array_values($this->tempPhotos); // Reindexar el array
        }
    }

    // Método para crear miniaturas
    private function createThumbnail($photo)
    {
        try {
            // Asegurarse de que existe el directorio para las miniaturas
            $thumbnailDir = 'property-thumbnails';
            $storagePath = storage_path('app/public/' . $thumbnailDir);

            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

            // Crear una instancia de la imagen
            $image = \Intervention\Image\Facades\Image::make($photo->getRealPath());

            // Redimensionar a un tamaño de miniatura
            $image->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Generar un nombre único para la miniatura
            $filename = 'thumb_' . time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();

            // Ruta relativa para la BD
            $thumbnailPath = $thumbnailDir . '/' . $filename;

            // Ruta completa del sistema de archivos
            $fullPath = $storagePath . '/' . $filename;

            // Guardar la miniatura
            $image->save($fullPath);

            // Devolver la ruta relativa para guardar en la base de datos
            return $thumbnailPath;
        } catch (\Exception $e) {
            // Registrar el error para debugging
            Log::error('Error al crear miniatura: ' . $e->getMessage());
            return null;
        }
    }

    public function save()
    {
        // Validar el paso actual
        $this->validateStep();

        // Crear dirección
        $address = Address::create([
            'city_id' => $this->city_id,
            'street' => $this->street,
            'number' => $this->number,
            'floor' => $this->floor,
            'door' => $this->door,
            'postal_code' => $this->postal_code,
        ]);

        // Crear propiedad
        $property = Property::create([
            'reference' => $this->reference,
            'operation_id' => $this->operation_id,
            'property_type_id' => $this->property_type_id,
            'status_id' => $this->status_id,
            'title' => $this->title,
            'meta_description' => $this->meta_description,
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
            'orientation' => $this->orientation,
            'exterior_type' => $this->exterior_type,
            'kitchen_type' => $this->kitchen_type,
            'heating_type' => $this->heating_type,
            'interior_carpentry' => $this->interior_carpentry,
            'exterior_carpentry' => $this->exterior_carpentry,
            'flooring_type' => $this->flooring_type,
            'views' => $this->views,
            'distance_to_sea' => $this->distance_to_sea,
            'regime' => $this->regime,
            'google_map' => $this->google_map,
            'description' => $this->description,
            'address_id' => $address->id,
        ]);

        // Crear traducciones para la propiedad
        $this->createTranslations($property);

        // Después de crear la propiedad, guardar las fotos
        if (!empty($this->tempPhotos)) {
            foreach ($this->tempPhotos as $index => $photo) {
                try {
                    // Crear miniatura primero (mientras el archivo temporal está disponible)
                    $thumbnailPath = $this->createThumbnail($photo);

                    // Guardar la imagen original
                    $imagePath = $photo->store('property-images', 'public');

                    // Guardar en la base de datos
                    PropertyImage::create([
                        'property_id' => $property->id,
                        'image_path' => $imagePath,
                        'thumbnail_path' => $thumbnailPath,
                        'order' => $index + 1,
                        'is_featured' => ($index === 0) ? true : false,
                        'alt_text' => $this->title
                    ]);
                } catch (\Exception $e) {
                    Log::error('Error al guardar imagen: ' . $e->getMessage());
                    // Opcionalmente, puedes añadir un mensaje de error a la sesión
                    // session()->flash('image_error', 'Error al procesar algunas imágenes');
                }
            }
        }

        session()->flash('message', 'Propiedad creada con éxito.');
        return redirect()->route('admin.properties.index');
    }

    /**
     * Crea traducciones para una propiedad
     */
    private function createTranslations($property)
    {
        // Idiomas a traducir
        $languages = ['en', 'fr', 'de'];

        // Campos que necesitan traducción
        $fieldsToTranslate = [
            'title' => $this->title,
            'description' => $this->description,
            'meta_description' => $this->meta_description,
            'condition' => $this->condition,
            'orientation' => $this->orientation,
            'exterior_type' => $this->exterior_type,
            'kitchen_type' => $this->kitchen_type,
            'heating_type' => $this->heating_type,
            'interior_carpentry' => $this->interior_carpentry,
            'exterior_carpentry' => $this->exterior_carpentry,
            'flooring_type' => $this->flooring_type,
            'views' => $this->views,
            'regime' => $this->regime
        ];

        try {

            foreach ($languages as $lang) {
                $translationData = [
                    'property_id' => $property->id,
                    'locale' => $lang,
                ];

                foreach ($fieldsToTranslate as $field => $value) {
                    if (!empty($value)) {
                        try {
                            $translatedText = LibreTranslateHelper::translate($value, 'es', $lang);
                            $translationData[$field] = $translatedText;

                        } catch (\Exception $e) {
                            Log::error("Error al traducir campo: $field", [
                                'lang' => $lang,
                                'error' => $e->getMessage(),
                                'property_id' => $property->id
                            ]);
                            // Si falla la traducción, usar el texto original
                            $translationData[$field] = $value;
                        }
                    }
                }

                // Guardar la traducción
                PropertyTranslation::create($translationData);

            }

        } catch (\Exception $e) {
            Log::error('Error general en el proceso de traducción', [
                'property_id' => $property->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
