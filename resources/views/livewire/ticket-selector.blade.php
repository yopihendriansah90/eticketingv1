<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <form wire:submit.prevent="addToCart">
        <div class="space-y-4">
            @foreach($event->tickets as $ticket)
                <div class="border rounded-lg p-4 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $ticket->name }}</h3>
                        <p class="text-md font-bold text-gray-900">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="flex items-center">
                        <button type="button" wire:click="decrement({{ $ticket->id }})" class="quantity-minus p-2 border border-gray-300 rounded-l-md">-</button>
                        <input type="number" wire:model="quantities.{{ $ticket->id }}" min="0" value="0" class="h-10 w-16 text-center border-t border-b border-gray-300 focus:ring-0 focus:border-gray-300 px-0 py-2">
                        <button type="button" wire:click="increment({{ $ticket->id }})" class="quantity-plus p-2 border border-gray-300 rounded-r-md">+</button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex justify-between items-center">
            <span class="text-xl font-bold text-gray-800">Total:</span>
            <span class="text-xl font-bold text-blue-600">Rp {{ number_format($this->total, 0, ',', '.') }}</span>
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg text-lg">
                Add to Cart
            </button>
        </div>
    </form>
</div>