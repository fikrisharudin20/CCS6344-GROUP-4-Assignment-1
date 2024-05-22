<x-app-layout>
    <x-slot name="header">
        <h2 class="w-fit font-semibold text-xl leading-tight bg-gradient-to-r from-cyan-500 to-purple-500 text-transparent bg-clip-text">
            {{ __('Payment Successful') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold mb-4">Thank You</h1>
                    <p>Your payment has been made successfully.</p>
                    <x-primary-link class="mt-4" href="{{route('purchased_events.index')}}">Done</x-primary-link>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
