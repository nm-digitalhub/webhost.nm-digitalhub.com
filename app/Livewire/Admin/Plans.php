<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use Livewire\Component;

class Plans extends Component
{
    protected $paginationTheme = 'tailwind';

    public $search = '';

    public $type = '';

    public $sortField = 'created_at';

    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
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

    public function updatingType()
    {
        $this->resetPage();
    }

    public function render()
    {
        // In a real application, this would fetch plans from the database
        // $plans = Plan::search($this->search)
        //     ->when($this->type, fn($query, $type) => $query->where('type', $type))
        //     ->orderBy($this->sortField, $this->sortDirection)
        //     ->paginate(10);

        // Demo data for now
        $plans = [];

        return view('livewire.admin.plans', [
            'plans' => $plans,
        ])->layout('layouts.admin');
    }
}
