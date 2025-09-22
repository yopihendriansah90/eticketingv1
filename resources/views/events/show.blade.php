@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Event Image --}}
        <div>
            <img src="{{ $event->getFirstMediaUrl('posters') ?: 'https://via.placeholder.com/600x800' }}" alt="{{ $event->title }}" class="rounded-lg shadow-lg w-full h-auto object-cover">
        </div>

        {{-- Event Details and Ticket Selection --}}
        <div class="flex flex-col">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $event->title }}</h1>
            <div class="text-lg text-gray-600 mb-4">
                <span>{{ $event->start_date->format('D, d M Y') }}</span>
                <span class="mx-2">|</span>
                <span>{{ $event->location }}</span>
            </div>
            <p class="text-gray-700 mb-6">{{ $event->description }}</p>

            <div class="border-t border-gray-200 pt-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Choose Your Ticket</h2>

                @if($event->tickets->isNotEmpty())
                    @livewire('ticket-selector', ['event' => $event])
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
