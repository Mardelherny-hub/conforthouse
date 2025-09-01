<?php
namespace App\Livewire\Admin\Clients;

use Livewire\Component;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClientNew extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $status = '1';

    protected $rules = [
        'name' => 'required|min:3|max:100',
        'email' => 'required|email|unique:clients,email',
        'phone' => 'nullable|string|max:20',
        'status' => 'in:1,0'
    ];

    protected $messages = [
        'name.required' => 'El nombre es obligatorio',
        'name.min' => 'El nombre debe tener al menos 3 caracteres',
        'name.max' => 'El nombre no puede superar los 100 caracteres',
        'email.required' => 'El email es obligatorio',
        'email.email' => 'Debe ser un email válido',
        'email.unique' => 'Este email ya está registrado',
        'phone.max' => 'El teléfono no puede superar los 20 caracteres',
        'status.in' => 'El estado seleccionado no es válido'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function saveClient()
    {
        $validatedData = $this->validate();

        try {
            $client = Client::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'] ?? null,
                'status' => $validatedData['status']
            ]);

            session()->flash('message', 'Cliente creado exitosamente');

            // Limpiar formulario después de crear
            $this->reset(['name', 'email', 'phone', 'status']);

            // Redireccionar a la lista de clientes o mostrar un mensaje
            return redirect()->route('admin.clients.index');

        } catch (\Exception $e) {
            session()->flash('error', 'No se pudo crear el cliente: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.clients.client-new');
    }
}
