<?php
namespace App\Livewire\Admin\Caracteristics;

use Livewire\Component;
use App\Models\PropertyType;
use App\Models\PropertyTypeTranslation;
use Illuminate\Support\Facades\App;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use App\Helpers\LibreTranslateHelper;

class Types extends Component
{
    use WithPagination;

    public $typeId, $name, $locale;
    public $isEdit = false;
    public $search = '';
    public $confirmingDelete = false;
    public $typeToDelete;
    public $perPage = 10;
    public $editingTypeId = null;

    protected $queryString = ['search'];

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $query = PropertyType::query();
                    if ($this->isEdit) {
                        $query->where('id', '!=', $this->typeId);
                    }

                    $exists = $query->whereHas('translations', function ($query) use ($value) {
                        $query->where('name', $value)
                            ->where('locale', 'es'); // Validamos solo en español (idioma principal)
                    })->exists();

                    if ($exists) {
                        $fail('Este nombre ya existe.');
                    }
                },
            ],
        ];
    }

    protected $messages = [
        'name.required' => 'El nombre del Tipo es obligatorio.',
        'name.max' => 'El nombre no puede exceder los 255 caracteres.',
    ];

    public function mount()
    {
        $this->locale = 'es'; // Siempre comenzamos con español como idioma principal
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        if ($propertyName === 'search') {
            $this->resetPage();
        }
    }

    public function store()
    {
        $this->validate();

        // Crear el type
        $type = PropertyType::create(['name' => $this->name]);

        // Crear la traducción en español (idioma principal)
        PropertyTypeTranslation::create([
            'property_type_id' => $type->id,
            'locale' => 'es',
            'name' => $this->name,
        ]);

        // Crear traducciones automáticas para otros idiomas
        $this->createTranslations($type);

        $this->resetForm();
        $this->dispatch('type-saved', 'Tipo creado correctamente');
    }

    public function toggleEdit($id)
    {
        if ($this->editingTypeId === $id) {
            $this->editingTypeId = null;
        } else {
            $this->editingTypeId = $id;
            $this->edit($id);
        }
    }

    public function edit($id)
    {
        $type = PropertyType::findOrFail($id);
        $this->typeId = $type->id;

        // Obtener la traducción en el idioma actual
        $translation = $type->translations()->where('locale', $this->locale)->first();
        $this->name = $translation ? $translation->name : '';

        $this->isEdit = true;
    }

    public function update()
    {
        // Si estamos editando en español, necesitamos validar y traducir
        if ($this->locale === 'es') {
            $this->validate();

            $type = PropertyType::findOrFail($this->typeId);
            $type->update(['name' => $this->name]);

            // Actualizar la traducción en español
            PropertyTypeTranslation::updateOrCreate(
                ['property_type_id' => $type->id, 'locale' => 'es'],
                ['name' => $this->name]
            );

            // Actualizar traducciones en otros idiomas
            $this->updateTranslations($type);

            $this->dispatch('type-updated', 'Tipo actualizado correctamente');
        } else {
            // Si estamos editando un idioma que no es español, solo actualizamos esa traducción
            $this->validate([
                'name' => 'required|string|max:255',
            ]);

            PropertyTypeTranslation::updateOrCreate(
                ['property_type_id' => $this->typeId, 'locale' => $this->locale],
                ['name' => $this->name]
            );

            $this->dispatch('type-updated', 'Traducción actualizada correctamente');
        }

        $this->resetForm();
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->typeToDelete = $id;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = false;
        $this->typeToDelete = null;
    }

    public function delete()
    {
        $type = PropertyType::findOrFail($this->typeToDelete);
        $type->delete();

        $this->confirmingDelete = false;
        $this->typeToDelete = null;
        $this->dispatch('type-deleted', 'Tipo eliminado correctamente');
    }

    private function resetForm()
    {
        $this->name = '';
        $this->typeId = null;
        $this->isEdit = false;
        $this->editingTypeId = null;
    }

    public function changeLocale($locale)
    {
        $this->locale = $locale;
        if ($this->isEdit && $this->typeId) {
            $this->edit($this->typeId);
        }
    }

    /**
     * Crea traducciones para un Tipo
     */
    private function createTranslations($type)
    {
        // Idiomas a traducir
        $languages = ['en', 'fr', 'de'];

        try {
            foreach ($languages as $lang) {
                // Intentar traducir el nombre
                try {
                    $translatedName = LibreTranslateHelper::translate($this->name, 'es', $lang);

                    // Guardar la traducción
                    PropertyTypeTranslation::create([
                        'propertytype_id' => $type->id,
                        'locale' => $lang,
                        'name' => $translatedName,
                    ]);
                } catch (\Exception $e) {
                    Log::error("Error al traducir Tipo", [
                        'lang' => $lang,
                        'error' => $e->getMessage(),
                        'property_type_id' => $type->id
                    ]);
                    // Si falla la traducción, usar el texto original
                    PropertyTypeTranslation::create([
                        'property_type_id' => $type->id,
                        'locale' => $lang,
                        'name' => $this->name,
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error("Error general en traducciones", [
                'error' => $e->getMessage(),
                'property_type_id' => $type->id
            ]);
        }
    }

    /**
     * Actualiza traducciones para un Tipo
     */
    private function updateTranslations($type)
    {
        // Idiomas a traducir
        $languages = ['en', 'fr', 'de'];

        try {
            foreach ($languages as $lang) {
                // Intentar traducir el nombre
                try {
                    $translatedName = LibreTranslateHelper::translate($this->name, 'es', $lang);

                    // Actualizar la traducción
                    PropertyTypeTranslation::updateOrCreate(
                        ['property_type_id' => $type->id, 'locale' => $lang],
                        ['name' => $translatedName]
                    );
                } catch (\Exception $e) {
                    Log::error("Error al actualizar traducción de Tipo", [
                        'lang' => $lang,
                        'error' => $e->getMessage(),
                        'property_type_id' => $type->id
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error("Error general al actualizar traducciones", [
                'error' => $e->getMessage(),
                'property_type_id' => $type->id
            ]);
        }
    }

    public function getTypesProperty()
    {
        return PropertyType::with(['translations' => function($query) {
                $query->where('locale', $this->locale);
            }])
            ->when($this->search, function($query) {
                $query->whereHas('translations', function($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.caracteristics.types', [
            'typesList' => $this->types,
            'availableLocales' => ['es', 'en', 'fr', 'de'],
        ]);
    }
}
