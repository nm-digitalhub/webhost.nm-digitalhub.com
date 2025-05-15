<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use Livewire\Component;

class Search extends Component
{
    public $query = '';

    public function mount()
    {
        $this->query = request('name') ?? '';
    }

    public function render()
    {
        // לוגיקת חיפוש - יכולה להיות מנוהלת כאן במקום בקונטרולר

        return view('livewire.search', [
            'query' => $this->query,
        ]);
    }
}
