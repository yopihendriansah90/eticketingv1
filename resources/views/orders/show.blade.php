@extends('layouts.app')

@section('title', 'Order Summary')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Thank You for Your Order!</h1>
            <p class="text-gray-600">Your order has been placed successfully.</p>
        </div>

        <div class="border-t border-b border-gray-200 py-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Order Summary</h2>
            <div class="flex justify-between mb-2">
                <span class="text-gray-600">Order ID:</span>
                <span class="font-mono text-gray-800">#{{ $order->id }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Order Status:</span>
                <span class="font-semibold capitalize px-2 py-1 text-sm rounded-full 
                    @switch($order->status)
                        @case('pending') bg-yellow-200 text-yellow-800 @break
                        @case('paid') bg-green-200 text-green-800 @break
                        @case('cancelled') bg-red-200 text-red-800 @break
                        @default bg-gray-200 text-gray-800
                    @endswitch">
                    {{ $order->status }}
                </span>
            </div>
        </div>

        <div class="py-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Items</h3>
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $item->ticket->name }}</p>
                        <p class="text-sm text-gray-500">{{ $item->ticket->event->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-800">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="border-t border-gray-200 pt-6">
            <div class="flex justify-between items-center">
                <span class="text-xl font-bold text-gray-800">Total</span>
                <span class="text-xl font-bold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        @if($order->status == 'pending')
        <div class="mt-8 text-center">
            <a href="#" class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg text-lg">
                Pay Now
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
