<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;

class TicketSelector extends Component
{
    public Event $event;
    public array $quantities = [];

    public function mount(Event $event)
    {
        $this->event = $event;
        foreach ($event->tickets as $ticket) {
            $this->quantities[$ticket->id] = 0;
        }
    }

    public function increment(int $ticketId)
    {
        $this->quantities[$ticketId]++;
    }

    public function decrement(int $ticketId)
    {
        if ($this->quantities[$ticketId] > 0) {
            $this->quantities[$ticketId]--;
        }
    }

    public function getTotalProperty()
    {
        $total = 0;
        foreach ($this->quantities as $ticketId => $quantity) {
            $ticket = $this->event->tickets->find($ticketId);
            if ($ticket) {
                $total += $ticket->price * $quantity;
            }
        }
        return $total;
    }

    public function addToCart()
    {
        // Implement your add to cart logic here
        // For now, let's just dump the selected quantities and total
        session()->flash('message', 'Tickets added to cart: ' . json_encode($this->quantities) . ' Total: Rp ' . number_format($this->total, 0, ',', '.'));
        // You would typically redirect or dispatch an event here
    }

    public function render()
    {
        return view('livewire.ticket-selector');
    }
}