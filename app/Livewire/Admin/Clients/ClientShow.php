<?php
namespace App\Livewire\Admin\Clients;

use Livewire\Component;
use App\Models\Client;

class ClientShow extends Component
{
    public $client;
    public $clientId;

    public function mount(Client $client)
    {
        $this->client= $client->id;
        $this->client = Client::findOrFail($client->id);
    }

    public function render()
    {
        return view('livewire.admin.clients.client-show');
    }
}
