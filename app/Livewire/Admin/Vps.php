<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use Livewire\Component;

class Vps extends Component
{
    protected $paginationTheme = 'tailwind';

    public $search = '';

    public $status = '';

    public $sortField = 'created_at';

    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        // In a real application, this would fetch VPS servers from the database
        // $vpsServers = VpsServer::search($this->search)
        //     ->when($this->status, fn($query, $status) => $query->where('status', $status))
        //     ->orderBy($this->sortField, $this->sortDirection)
        //     ->paginate(10);

        // Demo data for now
        $vpsServers = [];

        return view('livewire.admin.vps', [
            'vpsServers' => $vpsServers,
        ])->layout('livewire.admin.layout');
    }
}
