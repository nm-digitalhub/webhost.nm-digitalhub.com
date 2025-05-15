<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use Livewire\Component;

class Invoices extends Component
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
        // In a real application, this would fetch invoices from the database
        // $invoices = Invoice::search($this->search)
        //     ->when($this->status, fn($query, $status) => $query->where('status', $status))
        //     ->orderBy($this->sortField, $this->sortDirection)
        //     ->paginate(10);

        // Demo data for now
        $invoices = [];

        return view('livewire.admin.invoices', [
            'invoices' => $invoices,
        ])->layout('layouts.admin');
    }
}
