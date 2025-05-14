<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class Hosting extends Component
{
    use WithPagination;

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
        // In a real application, this would fetch hosting accounts from the database
        // $hostingAccounts = HostingAccount::search($this->search)
        //     ->when($this->status, fn($query, $status) => $query->where('status', $status))
        //     ->orderBy($this->sortField, $this->sortDirection)
        //     ->paginate(10);

        $hostingAccounts = [];

        return view('livewire.admin.hosting', [
            'hostingAccounts' => $hostingAccounts,
        ])->layout('layouts.admin');
    }
}
