<?php
namespace App\Livewire\Admin\Clients;

use Livewire\Component;
use App\Models\Client;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class AdminClientsList extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $search = '';

    #[Url(except: 'id')]
    public $sortField = 'id';

    #[Url(except: 'desc')]
    public $sortDirection = 'desc';

    #[Url(except: 10)]
    public $perPage = 10;

    #[Url]
    public $filters = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'status' => ''
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilters()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function resetFilters()
    {
        $this->reset('filters');
        $this->resetPage();
    }

    public function deleteClient(Client $client)
    {
        $client->delete();
        session()->flash('message', 'Cliente eliminado correctamente');
    }

    public function render()
    {
        $clients = Client::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'LIKE', "%{$this->search}%")
                      ->orWhere('email', 'LIKE', "%{$this->search}%")
                      ->orWhere('phone', 'LIKE', "%{$this->search}%");
                });
            })
            ->when($this->filters['email'], function ($query) {
                $query->where('email', 'LIKE', "%{$this->filters['email']}%");
            })
            ->when($this->filters['phone'], function ($query) {
                $query->where('phone', 'LIKE', "%{$this->filters['phone']}%");
            })
            ->when($this->filters['status'], function ($query) {
                $query->where('status', 'LIKE', "%{$this->filters['status']}%");
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.clients.admin-clients-list', [
            'clients' => $clients,
        ]);
    }
}
