<?php

namespace App\Livewire\Admin;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class Tickets
 */
class Tickets extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    /**
     * Ticket status constants
     */
    public const STATUS_OPEN = 'open';

    public const STATUS_CLOSED = 'closed';

    public const STATUS_PENDING = 'pending';

    /**
     * Ticket priority constants
     */
    public const PRIORITY_LOW = 'low';

    public const PRIORITY_MEDIUM = 'medium';

    public const PRIORITY_HIGH = 'high';

    /**
     * @var string Search query parameter
     */
    #[Url]
    public string $search = '';

    /**
     * @var string Status filter parameter
     */
    #[Url]
    public string $status = '';

    /**
     * @var string Priority filter parameter
     */
    #[Url]
    public string $priority = '';

    /**
     * Validation rules
     */
    protected $rules = [
        'status' => 'nullable|string|in:open,closed,pending',
        'priority' => 'nullable|string|in:low,medium,high',
        'search' => 'nullable|string|max:255',
    ];

    /**
     * Render the component
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $tickets = Ticket::query()
            ->when($this->search, function (Builder $query) {
                $searchTerm = '%'.$this->search.'%';

                return $query->where(function (Builder $q) use ($searchTerm) {
                    $q->where('subject', 'like', $searchTerm)
                        ->orWhereHas('user', function (Builder $userQuery) use ($searchTerm) {
                            $userQuery->where('name', 'like', $searchTerm);
                        });
                });
            })
            ->when($this->status, fn (Builder $query) => $query->where('status', $this->status))
            ->when($this->priority, fn (Builder $query) => $query->where('priority', $this->priority))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.tickets', [
            'tickets' => $tickets,
        ]);
    }

    /**
     * Reset pagination when search query is updated
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when status filter is updated
     */
    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when priority filter is updated
     */
    public function updatedPriority(): void
    {
        $this->resetPage();
    }

    /**
     * Mark a ticket as closed
     */
    public function markAsClosed(int $ticketId): void
    {
        $ticket = Ticket::findOrFail($ticketId);

        // Check if user has permission to update this ticket
        $this->authorize('update', $ticket);

        try {
            $ticket->status = self::STATUS_CLOSED;
            $ticket->save();

            // Use localization for message
            session()->flash('message', __('tickets.closed_successfully', [], 'he'));
        } catch (\Exception) {
            session()->flash('error', __('tickets.error_updating', [], 'he'));
        }
    }
}
