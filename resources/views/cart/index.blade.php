<x-app-layout>
    <x-slot name="header">
        <h2 class="w-fit font-semibold text-xl leading-tight bg-gradient-to-r from-cyan-500 to-purple-500 text-transparent bg-clip-text">
            {{ __('My Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($cartItems->isEmpty())
                        <div class="text-center text-gray-500 py-8">
                            <p class="text-lg">Your cart is empty.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="table-auto min-w-full mb-4 ">
                                <thead>
                                    <tr class="text-left">
                                        <th class="py-2 px-4 border-b">Event</th>
                                        <th class="py-2 px-4 border-b">Price (RM)</th>
                                        <th class="py-2 px-4 border-b">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalPrice = 0; @endphp
                                    @foreach ($cartItems as $item)
                                        @php $totalPrice += $item->event->price; @endphp
                                        <tr>
                                            <td class="py-2 px-4 border-b">{{ $item->event->name }}</td>
                                            <td class="py-2 px-4 border-b">{{ number_format($item->event->price, 2) }}</td>
                                            <td class="py-2 px-4 border-b">
                                                <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="hidden"><x-delete-icon/></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="py-2 px-4 font-bold" colspan="2" align="right">Total:</td>
                                        <td class="py-2 px-4">{{ number_format($totalPrice, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- Checkout Button -->
                        <div class="flex justify-end mt-4">
                            <form action="{{ route('payment.checkout') }}" method="GET">
                                <x-primary-button type="submit">
                                    Checkout
                                </x-primary-button>
                            </form>
                        </div> 
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

