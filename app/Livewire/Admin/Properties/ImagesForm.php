<?php

namespace App\Livewire\Admin\Properties;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\DB;
use App\Helpers\YoutubeHelper;

class ImagesForm extends Component
{
    use WithFileUploads;

    public $property;
    public $photos = [];
    public $tempPhotos = [];
    public $existingImages = [];

    // Video
    public $video = null;
    public $videoPreview = null;

    protected $listeners = ['refreshImages' => '$refresh'];

    public function mount($property)
    {
        $this->property = $property;
        $this->loadExistingImages();
        $this->video = $property->video;
        $this->updateVideoPreview();
    }

    public function updatedVideo()
    {
        $this->validateVideo();
        $this->updateVideoPreview();
    }

    protected function validateVideo()
    {
        $this->validate([
            'video' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!empty($value) && !YoutubeHelper::getVideoId($value)) {
                        $fail('Por favor, introduce una URL válida de YouTube.');
                    }
                },
            ],
        ]);
    }

    protected function updateVideoPreview()
    {
        if (!empty($this->video)) {
            $this->videoPreview = YoutubeHelper::getVideoId($this->video);
        } else {
            $this->videoPreview = null;
        }
    }

    public function loadExistingImages()
    {
        $this->existingImages = $this->property->images()->orderBy('order')->get();
    }

    public function updatedPhotos()
    {
        $this->validate([
            'photos.*' => 'image|max:2048', // Máximo 2MB por imagen
        ]);

        foreach ($this->photos as $photo) {
            $this->tempPhotos[] = [
                'original' => $photo,
            ];
        }

        $this->photos = []; // Limpiar el array de fotos después de procesarlas
        $this->dispatch('photos-updated');
    }

    public function removePhoto($index)
    {
        if (isset($this->tempPhotos[$index])) {
            unset($this->tempPhotos[$index]);
            $this->tempPhotos = array_values($this->tempPhotos); // Reindexar el array
        }
    }

    public function removeExistingImage($imageId)
    {
        try {
            Log::info('Attempting to remove image:', ['image_id' => $imageId]);

            DB::beginTransaction();

            $image = PropertyImage::findOrFail($imageId);
            Log::info('Image found:', ['image' => $image->toArray()]);

            // Remove physical files
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
                Log::info('Original image deleted');
            }

            if ($image->thumbnail_path && Storage::disk('public')->exists($image->thumbnail_path)) {
                Storage::disk('public')->delete($image->thumbnail_path);
                Log::info('Thumbnail deleted');
            }

            // Delete database record
            $image->delete();
            Log::info('Image record deleted from database');

            DB::commit();

            // Refresh images collection
            $this->existingImages = $this->property->images()->orderBy('order')->get();

            $this->dispatch('image-removed', [
                'type' => 'success',
                'message' => 'Imagen eliminada correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error removing image:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->dispatch('image-removal-failed', [
                'type' => 'error',
                'message' => 'Error al eliminar la imagen: ' . $e->getMessage()
            ]);
        }
    }

    public function saveAll()
    {
        try {
            // Validate video
            $this->validateVideo();

            // Save video if changed
            if ($this->video !== $this->property->video) {
                $videoId = !empty($this->video) ? YoutubeHelper::getVideoId($this->video) : null;
                $this->property->update(['video' => $videoId]);
            }

            // Save images
            if (!empty($this->tempPhotos)) {
                $this->saveImages();
            }

            session()->flash('message', 'Cambios guardados con éxito.');
            $this->dispatch('saved');

        } catch (\Exception $e) {
            Log::error('Error saving images and video: ' . $e->getMessage());
            session()->flash('error', 'Error al guardar los cambios. Por favor, intente nuevamente.');
        }
    }

    public function saveImages()
    {
        $this->validate([
            'tempPhotos.*' => 'array',
            'video' => [
                    'nullable',
                    function ($attribute, $value, $fail) {
                        if (!empty($value) && !YoutubeHelper::getVideoId($value)) {
                            $fail('Por favor, introduce una URL válida de YouTube.');
                        }
                    },
                ],
        ]);

        // Save video URL
        if ($this->video !== $this->property->video) {
            $videoId = !empty($this->video) ? YoutubeHelper::getVideoId($this->video) : null;
            $this->property->update(['video' => $videoId]);
        }

        if (!empty($this->tempPhotos)) {
            // Obtener el último orden de imagen existente
            $lastOrder = $this->property->images()->max('order') ?? 0;

            foreach ($this->tempPhotos as $index => $photo) {
                try {
                    // Crear miniatura primero
                    $thumbnailPath = $this->createThumbnail($photo);

                    // Guardar la imagen original
                    $imagePath = $photo['original']->store('property-images', 'public');

                    // Guardar en la base de datos
                    PropertyImage::create([
                        'property_id' => $this->property->id,
                        'image_path' => $imagePath,
                        'thumbnail_path' => $thumbnailPath,
                        'order' => $lastOrder + $index + 1,
                        'is_featured' => ($this->property->images()->count() === 0),
                        'alt_text' => $this->property->title
                    ]);
                } catch (\Exception $e) {
                    Log::error('Error al guardar imagen: ' . $e->getMessage());
                }
            }

            // Limpiar fotos temporales
            $this->tempPhotos = [];
            $this->photos = [];

            // Recargar imágenes existentes
            $this->loadExistingImages();

            session()->flash('message', 'Imágenes guardadas con éxito.');
        }
    }

    private function createThumbnail($photo)
    {
        try {
            // Asegurarse de que existe el directorio para las miniaturas
            $thumbnailDir = 'property-thumbnails';
            // Asegurarse de que existe el directorio en storage/app/public
            if (!Storage::disk('public')->exists($thumbnailDir)) {
                Storage::disk('public')->makeDirectory($thumbnailDir);
            }

            // Get the correct photo object
            $photoObject = $photo['original'];

            // Crear una instancia de la imagen
            $image = Image::make($photoObject->getRealPath());

            // Redimensionar a un tamaño de miniatura
            $image->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Generar un nombre único para la miniatura
            $filename = 'thumb_' . time() . '_' . uniqid() . '.' . $photoObject->getClientOriginalExtension();

            // Ruta relativa para la BD
            $thumbnailPath = $thumbnailDir . '/' . $filename;

            // Ruta completa del sistema de archivos
            $fullPath = storage_path('app/public/' . $thumbnailPath);

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

    public function reorderImages($newOrder)
    {
        foreach ($newOrder as $index => $imageId) {
            $image = PropertyImage::findOrFail($imageId);
            $image->update(['order' => $index + 1]);
        }

        $this->loadExistingImages();
        session()->flash('message', 'Orden de imágenes actualizado.');
    }

    public function render()
    {
        return view('livewire.admin.properties.images-form', [
            'existingImages' => $this->existingImages,
            'tempPhotos' => $this->tempPhotos
        ]);
    }
}
