<?php

use App\Models\Event;

use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Eager load the tickets relationship to prevent N+1 query issues
    $events = Event::with('tickets')->get();
    return view('welcome', ['events' => $events]);
});

Route::get('/events/{event:slug}', function (Event $event) {
    $event->load('tickets'); // Eager load tickets for the single event
    return view('events.show', ['event' => $event]);
})->name('events.show');

Route::post('/orders', function (Request $request) {
    // 1. Filter out tickets with 0 quantity and validate
    $validated = $request->validate([
        'tickets' => 'required|array',
    ]);
    $selectedTickets = array_filter($validated['tickets'], fn($quantity) => $quantity > 0);

    if (empty($selectedTickets)) {
        return back()->with('error', 'Please select at least one ticket.');
    }

    $ticketIds = array_keys($selectedTickets);
    $tickets = Ticket::find($ticketIds);

    // 2. Calculate total price and prepare order items
    $totalPrice = 0;
    $orderItems = [];
    foreach ($tickets as $ticket) {
        $quantity = $selectedTickets[$ticket->id];
        $totalPrice += $ticket->price * $quantity;
        $orderItems[] = [
            'ticket_id' => $ticket->id,
            'quantity' => $quantity,
            'price' => $ticket->price,
        ];
    }

    // 3. Create Order and OrderItems in a transaction
    $order = DB::transaction(function () use ($totalPrice, $orderItems) {
        $order = Order::create([
            'user_id' => 1, // Placeholder for authenticated user
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        $order->items()->createMany($orderItems);

        return $order;
    });

    // 4. Redirect to order summary page (to be created)
    return redirect()->route('orders.show', $order);
})->name('orders.store');

Route::get('/orders/{order}', function (Order $order) {
    // Eager load relations for summary display
    $order->load('items.ticket.event');
    return view('orders.show', ['order' => $order]);
})->name('orders.show');
