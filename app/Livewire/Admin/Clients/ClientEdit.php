<?php
namespace App\Livewire\Admin\Clients;

use Livewire\Component;
use App\Models\Client;
use Illuminate\Validation\Rule;

class ClientEdit extends Component
{
    public $client;
    public $name = '';
    public $email = '';
    public $phone = '';
    public $status = true;
    public $clientId;

    protected $rules = [
        'name' => 'required|min:3|max:100',
        'email' => 'required|email',
        'phone' => 'nullable|string|max:20',
        'status' => 'boolean'
    ];

    protected $messages = [
        'name.required' => 'El nombre es obligatorio',
        'name.min' => 'El nombre debe tener al menos 3 caracteres',
        'name.max' => 'El nombre no puede superar los 100 caracteres',
        'email.required' => 'El email es obligatorio',
        'email.email' => 'Debe ser un email válido',
        'phone.max' => 'El teléfono no puede superar los 20 caracteres'
    ];

    public function mount(Client $client)
    {

        $this->clientId = $client->id; // Fix: store the ID separately
        $this->client = $client; // Fix: store the whole client object
        $this->name = $client->name;
        $this->email = $client->email;
        $this->phone = $client->phone;
        $this->status = $client->status;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updateClient()
    {
        $validatedData = $this->validate([
            'name' => 'required|min:3|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('clients', 'email')->ignore($this->clientId)
            ],
            'phone' => 'nullable|string|max:20',
            'status' => 'boolean'
        ]);

        try {
            $client = Client::findOrFail($this->clientId);

            $client->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'status' => $validatedData['status']
            ]);

            session()->flash('message', 'Cliente actualizado exitosamente');

            return redirect()->route('admin.clients.index');

        } catch (\Exception $e) {
            session()->flash('error', 'No se pudo actualizar el cliente: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.clients.client-edit');
    }
}
