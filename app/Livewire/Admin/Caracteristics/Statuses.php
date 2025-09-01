<?php
namespace App\Livewire\Admin\Caracteristics;

use Livewire\Component;
use App\Models\Status;
use App\Models\StatusTranslation;
use Illuminate\Support\Facades\App;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use App\Helpers\LibreTranslateHelper;

class Statuses extends Component
{
    use WithPagination;

    public $statusId, $name, $locale;
    public $isEdit = false;
    public $search = '';
    public $confirmingDelete = false;
    public $statusToDelete;
    public $perPage = 10;
    public $editingStatusId = null;

    protected $queryString = ['search'];

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $query = Status::query();
                    if ($this->isEdit) {
                        $query->where('id', '!=', $this->statusId);
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
        'name.required' => 'El nombre del estado es obligatorio.',
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

        // Crear el status
        $status = Status::create(['name' => $this->name]);

        // Crear la traducción en español (idioma principal)
        StatusTranslation::create([
            'status_id' => $status->id,
            'locale' => 'es',
            'name' => $this->name,
        ]);

        // Crear traducciones automáticas para otros idiomas
        $this->createTranslations($status);

        $this->resetForm();
        $this->dispatch('status-saved', 'Estado creado correctamente');
    }

    public function toggleEdit($id)
    {
        if ($this->editingStatusId === $id) {
            $this->editingStatusId = null;
        } else {
            $this->editingStatusId = $id;
            $this->edit($id);
        }
    }

    public function edit($id)
    {
        $status = Status::findOrFail($id);
        $this->statusId = $status->id;

        // Obtener la traducción en el idioma actual
        $translation = $status->translations()->where('locale', $this->locale)->first();
        $this->name = $translation ? $translation->name : '';

        $this->isEdit = true;
    }

    public function update()
    {
        // Si estamos editando en español, necesitamos validar y traducir
        if ($this->locale === 'es') {
            $this->validate();

            $status = Status::findOrFail($this->statusId);
            $status->update(['name' => $this->name]);

            // Actualizar la traducción en español
            StatusTranslation::updateOrCreate(
                ['status_id' => $status->id, 'locale' => 'es'],
                ['name' => $this->name]
            );

            // Actualizar traducciones en otros idiomas
            $this->updateTranslations($status);

            $this->dispatch('status-updated', 'Estado actualizado correctamente');
        } else {
            // Si estamos editando un idioma que no es español, solo actualizamos esa traducción
            $this->validate([
                'name' => 'required|string|max:255',
            ]);

            StatusTranslation::updateOrCreate(
                ['status_id' => $this->statusId, 'locale' => $this->locale],
                ['name' => $this->name]
            );

            $this->dispatch('status-updated', 'Traducción actualizada correctamente');
        }

        $this->resetForm();
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->statusToDelete = $id;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = false;
        $this->statusToDelete = null;
    }

    public function delete()
    {
        $status = Status::findOrFail($this->statusToDelete);
        $status->delete();

        $this->confirmingDelete = false;
        $this->statusToDelete = null;
        $this->dispatch('status-deleted', 'Estado eliminado correctamente');
    }

    private function resetForm()
    {
        $this->name = '';
        $this->statusId = null;
        $this->isEdit = false;
        $this->editingStatusId = null;
    }

    public function changeLocale($locale)
    {
        $this->locale = $locale;
        if ($this->isEdit && $this->statusId) {
            $this->edit($this->statusId);
        }
    }

    /**
     * Crea traducciones para un estado
     */
    private function createTranslations($status)
    {
        // Idiomas a traducir
        $languages = ['en', 'fr', 'de'];

        try {
            foreach ($languages as $lang) {
                // Intentar traducir el nombre
                try {
                    $translatedName = LibreTranslateHelper::translate($this->name, 'es', $lang);

                    // Guardar la traducción
                    StatusTranslation::create([
                        'status_id' => $status->id,
                        'locale' => $lang,
                        'name' => $translatedName,
                    ]);
                } catch (\Exception $e) {
                    Log::error("Error al traducir estado", [
                        'lang' => $lang,
                        'error' => $e->getMessage(),
                        'status_id' => $status->id
                    ]);
                    // Si falla la traducción, usar el texto original
                    StatusTranslation::create([
                        'status_id' => $status->id,
                        'locale' => $lang,
                        'name' => $this->name,
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error("Error general en traducciones", [
                'error' => $e->getMessage(),
                'status_id' => $status->id
            ]);
        }
    }

    /**
     * Actualiza traducciones para un estado
     */
    private function updateTranslations($status)
    {
        // Idiomas a traducir
        $languages = ['en', 'fr', 'de'];

        try {
            foreach ($languages as $lang) {
                // Intentar traducir el nombre
                try {
                    $translatedName = LibreTranslateHelper::translate($this->name, 'es', $lang);

                    // Actualizar la traducción
                    StatusTranslation::updateOrCreate(
                        ['status_id' => $status->id, 'locale' => $lang],
                        ['name' => $translatedName]
                    );
                } catch (\Exception $e) {
                    Log::error("Error al actualizar traducción de estado", [
                        'lang' => $lang,
                        'error' => $e->getMessage(),
                        'status_id' => $status->id
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error("Error general al actualizar traducciones", [
                'error' => $e->getMessage(),
                'status_id' => $status->id
            ]);
        }
    }

    public function getStatusesProperty()
    {
        return Status::with(['translations' => function($query) {
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
        return view('livewire.admin.caracteristics.statuses', [
            'statusesList' => $this->statuses,
            'availableLocales' => ['es', 'en', 'fr', 'de'],
        ]);
    }
}
