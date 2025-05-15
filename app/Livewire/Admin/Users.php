<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use Livewire\Component;

class Users extends Component
{
    protected $paginationTheme = 'tailwind';

    public $search = '';

    public $role = '';

    public $sortField = 'created_at';

    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'role' => ['except' => ''],
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

    public function updatingRole()
    {
        $this->resetPage();
    }

    public function render()
    {
        // In a real application, this would fetch users from the database
        // $users = User::search($this->search)
        //     ->when($this->role, fn($query, $role) => $query->where('role', $role))
        //     ->orderBy($this->sortField, $this->sortDirection)
        //     ->paginate(10);

        // Demo data for now
        $users = [];

        return view('livewire.admin.users', [
            'users' => $users,
        ])->layout('layouts.admin');
    }
}
