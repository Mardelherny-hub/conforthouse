<?php
namespace App\Livewire\Admin\Caracteristics;

use Livewire\Component;
use App\Models\Operation;
use App\Models\OperationTranslation;
use Illuminate\Support\Facades\App;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use App\Helpers\LibreTranslateHelper;

class Operations extends Component
{
    use WithPagination;

    public $operationId, $name, $locale;
    public $isEdit = false;
    public $search = '';
    public $confirmingDelete = false;
    public $operationToDelete;
    public $perPage = 10;
    public $editingOperationId = null;

    protected $queryString = ['search'];

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $query = Operation::query();
                    if ($this->isEdit) {
                        $query->where('id', '!=', $this->operationId);
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
        'name.required' => 'El nombre de la operación es obligatorio.',
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

        // Crear el operation
        $operation = Operation::create(['name' => $this->name]);

        // Crear la traducción en español (idioma principal)
        OperationTranslation::create([
            'operation_id' => $operation->id,
            'locale' => 'es',
            'name' => $this->name,
        ]);

        // Crear traducciones automáticas para otros idiomas
        $this->createTranslations($operation);

        $this->resetForm();
        $this->dispatch('operation-saved', 'Operación creado correctamente');
    }

    public function toggleEdit($id)
    {
        if ($this->editingOperationId === $id) {
            $this->editingOperationId = null;
        } else {
            $this->editingOperationId = $id;
            $this->edit($id);
        }
    }

    public function edit($id)
    {
        $operation = Operation::findOrFail($id);
        $this->operationId = $operation->id;

        // Obtener la traducción en el idioma actual
        $translation = $operation->translations()->where('locale', $this->locale)->first();
        $this->name = $translation ? $translation->name : '';

        $this->isEdit = true;
    }

    public function update()
    {
        // Si estamos editando en español, necesitamos validar y traducir
        if ($this->locale === 'es') {
            $this->validate();

            $operation = Operation::findOrFail($this->operationId);
            $operation->update(['name' => $this->name]);

            // Actualizar la traducción en español
            OperationTranslation::updateOrCreate(
                ['operation_id' => $operation->id, 'locale' => 'es'],
                ['name' => $this->name]
            );

            // Actualizar traducciones en otros idiomas
            $this->updateTranslations($operation);

            $this->dispatch('operation-updated', 'Operación actualizado correctamente');
        } else {
            // Si estamos editando un idioma que no es español, solo actualizamos esa traducción
            $this->validate([
                'name' => 'required|string|max:255',
            ]);

            OperationTranslation::updateOrCreate(
                ['operation_id' => $this->operationId, 'locale' => $this->locale],
                ['name' => $this->name]
            );

            $this->dispatch('operation-updated', 'Traducción actualizada correctamente');
        }

        $this->resetForm();
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->operationToDelete = $id;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = false;
        $this->operationToDelete = null;
    }

    public function delete()
    {
        $operation = Operation::findOrFail($this->operationToDelete);
        $operation->delete();

        $this->confirmingDelete = false;
        $this->operationToDelete = null;
        $this->dispatch('operation-deleted', 'Operación eliminado correctamente');
    }

    private function resetForm()
    {
        $this->name = '';
        $this->operationId = null;
        $this->isEdit = false;
        $this->editingOperationId = null;
    }

    public function changeLocale($locale)
    {
        $this->locale = $locale;
        if ($this->isEdit && $this->operationId) {
            $this->edit($this->operationId);
        }
    }

    /**
     * Crea traducciones para un Operación
     */
    private function createTranslations($operation)
    {
        // Idiomas a traducir
        $languages = ['en', 'fr', 'de', 'nl'];

        try {
            foreach ($languages as $lang) {
                // Intentar traducir el nombre
                try {
                    $translatedName = LibreTranslateHelper::translate($this->name, 'es', $lang);

                    // Guardar la traducción
                    OperationTranslation::create([
                        'operation_id' => $operation->id,
                        'locale' => $lang,
                        'name' => $translatedName,
                    ]);
                } catch (\Exception $e) {
                    Log::error("Error al traducir Operación", [
                        'lang' => $lang,
                        'error' => $e->getMessage(),
                        'operation_id' => $operation->id
                    ]);
                    // Si falla la traducción, usar el texto original
                    OperationTranslation::create([
                        'operation_id' => $operation->id,
                        'locale' => $lang,
                        'name' => $this->name,
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error("Error general en traducciones", [
                'error' => $e->getMessage(),
                'operation_id' => $operation->id
            ]);
        }
    }

    /**
     * Actualiza traducciones para un Operación
     */
    private function updateTranslations($operation)
    {
        // Idiomas a traducir
        $languages = ['en', 'fr', 'de', 'nl'];

        try {
            foreach ($languages as $lang) {
                // Intentar traducir el nombre
                try {
                    $translatedName = LibreTranslateHelper::translate($this->name, 'es', $lang);

                    // Actualizar la traducción
                    OperationTranslation::updateOrCreate(
                        ['operation_id' => $operation->id, 'locale' => $lang],
                        ['name' => $translatedName]
                    );
                } catch (\Exception $e) {
                    Log::error("Error al actualizar traducción de Operación", [
                        'lang' => $lang,
                        'error' => $e->getMessage(),
                        'operation_id' => $operation->id
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error("Error general al actualizar traducciones", [
                'error' => $e->getMessage(),
                'operation_id' => $operation->id
            ]);
        }
    }

    public function getOperationsProperty()
    {
        $query = Operation::query();

        if ($this->locale === 'es') {
            // Para español, buscar en la tabla operations
            if ($this->search) {
                $query->where('name', 'like', '%' . $this->search . '%');
            }
        } else {
            // Para otros idiomas, cargar las traducciones
            $query->with(['translations' => function($query) {
                $query->where('locale', $this->locale);
            }]);

            // Búsqueda en traducciones para idiomas que no son español
            if ($this->search) {
                $query->whereHas('translations', function($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->where('locale', $this->locale);
                });
            }
        }

        return $query->orderBy('id', 'desc')->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.caracteristics.operations', [
            'operationList' => $this->operations,
            'availableLocales' => ['es', 'en', 'fr', 'de'],
        ]);
    }
}
