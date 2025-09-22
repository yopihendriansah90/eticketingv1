@extends('layouts.app')

@section('title', $event->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Event Image --}}
        <div>
            <img src="{{ $event->image_url ?? 'https://via.placeholder.com/600x800' }}" alt="{{ $event->name }}" class="rounded-lg shadow-lg w-full h-auto object-cover">
        </div>

        {{-- Event Details and Ticket Selection --}}
        <div class="flex flex-col">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $event->name }}</h1>
            <div class="text-lg text-gray-600 mb-4">
                <span>{{ $event->start_date->format('D, d M Y') }}</span>
                <span class="mx-2">|</span>
                <span>{{ $event->location }}</span>
            </div>
            <p class="text-gray-700 mb-6">{{ $event->description }}</p>

            <div class="border-t border-gray-200 pt-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Choose Your Ticket</h2>

                @if($event->tickets->isNotEmpty())
                    <form action="{{ route('orders.store') }}" method="POST"> {{-- Placeholder for cart/order route --}}
                        @csrf
                        <div class="space-y-4">
                            @foreach($event->tickets as $ticket)
                                <div class="border rounded-lg p-4 flex justify-between items-center">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $ticket->name }}</h3>
                                        <p class="text-md font-bold text-gray-900">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <label for="ticket_{{ $ticket->id }}" class="sr-only">Quantity</label>
                                        <input type="number" id="ticket_{{ $ticket->id }}" name="tickets[{{ $ticket->id }}]" min="0" value="0" class="w-20 text-center border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg text-lg">
                                Add to Cart
                            </button>
                        </div>
                    </form>
                @else
                    <div class="bg-gray-100 rounded-lg p-8 text-center">
                        <p class="text-lg font-semibold text-gray-700">Tickets for this event are not yet available.</p>
                        <p class="text-gray-500">Please check back later.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
