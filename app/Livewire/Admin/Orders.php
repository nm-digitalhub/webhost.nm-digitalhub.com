<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Attributes\Url;
use Livewire\Component;

class Orders extends Component
{
    #[Url]
    public string $search = '';

    #[Url]
    public string $status = '';

    public function render()
    {
        $orders = Order::query()
            ->when($this->search, fn ($query) => $query->where('order_number', 'like', '%' . $this->search . '%')
                ->orWhereHas('user', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                }))
            ->when($this->status, fn ($query) => $query->where('status', $this->status))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.orders', [
            'orders' => $orders,
        ]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }
}
