@extends('layouts.app')

@section('title', 'Toko Online')

@section('content')
    {{-- Hero Section --}}
    <div class="bg-cover bg-center h-64 rounded-md shadow-lg text-white" style="">
        <div class="bg-black bg-opacity-50 h-full rounded-md flex flex-col justify-center items-center">
            <h1 class="text-4xl font-bold mb-2">Discover Your Next Experience</h1>
            <p class="text-xl">Buy tickets for the best events</p>
        </div>
    </div>

    {{-- Events Section --}}
    <div class="mt-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Upcoming Events</h2>
        
        {{-- Dynamic Event Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($events as $event)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col group">
                <div class="relative">
                    {{-- Mengubah aspect ratio ke potrait (3:4) --}}
                    <div class="aspect-w-3 aspect-h-4">
                        <img src="{{ $event->image_url ?? 'https://images.tokopedia.net/img/cache/700/aphluv/1997/1/1/b7d429ac2d4c42e8aeb0d16b88d4ac67~.jpeg' }}" alt="{{ $event->name }}" class="object-cover w-full h-full">
                    </div>
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300"></div>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <h3 class="text-lg font-bold text-gray-900 mb-1 truncate">{{ $event->name }}</h3>
                    <p class="text-sm text-gray-500 mb-2">{{ $event->start_date->format('d M Y') }} | {{ $event->location }}</p>
                    <div class="flex-grow"></div>
                    <div class="mt-2 mb-4">
                        @if($event->tickets->isNotEmpty())
                            <p class="text-sm text-gray-600">Mulai dari</p>
                            <p class="text-xl font-bold text-gray-900">Rp {{ number_format($event->tickets->min('price'), 0, ',', '.') }}</p>
                        @else
                            <p class="text-lg font-bold text-gray-900">Segera Hadir</p>
                        @endif
                    </div>
                    <a href="{{ route('events.show', $event) }}" class="w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors duration-300">
                        View Details
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection