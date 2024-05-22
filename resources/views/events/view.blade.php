<x-app-layout>
    <x-slot name="header">
        <h2
            class="w-fit font-semibold text-xl leading-tight bg-gradient-to-r from-cyan-500 to-purple-500 text-transparent bg-clip-text">
            {{ __('Event Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Alert Message --}}
                    @if (session()->has('success'))
                        <div
                            class="text-center px-4 py-3 mb-4 bg-green-100 border border-green-400 text-green-700 rounded relative">
                            <h5 class="font-semibold">{{ session('success') }}</h5>
                        </div>
                    @endif

                    <!-- Event Details -->
                    <h1 class="text-2xl font-semibold">{{ $event->name }}</h1>
                    <div class="my-4">

                        {{-- Date --}}
                        <div class="block">
                            <div class="inline-flex space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-6 h-6">
                                    <path fill-rule="evenodd"
                                        d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <p>{{ date('d F Y', strtotime($event->date)) }}</p>
                            </div>
                        </div>

                        {{-- Time --}}
                        <div class="block">
                            <div class="inline-flex space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <p>{{ \Carbon\Carbon::parse($event->startTime)->format('h:i A') }} - {{ \Carbon\Carbon::parse($event->endTime)->format('h:i A') }}</p>
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="block">
                            <div class="inline-flex space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                <p>{{ $event->address }}</p>
                            </div>
                        </div>

                        {{-- Organiser --}}
                        <div class="my-4">
                            <h2 class="text-lg font-semibold">Event Organiser</h2>
                            <p>{{ $event->user->name }}</p>
                        </div>

                        {{-- Description --}}
                        <div class="my-4">
                            <h2 class="text-lg font-semibold">Description</h2>
                            <p>{{ $event->description }}</p>
                        </div>

                        {{-- Ticket Price --}}
                        <h2 class="text-lg font-semibold">Ticket Price</h2>
                        <p>RM {{ number_format($event->price, 2) }}</p>
                    </div>

                    <!-- Add To Cart Form -->
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        <div class="flex space-x-4">
                            <x-secondary-button type="button" class="w-full" onclick="window.history.back()">
                                Back
                            </x-secondary-button>
                            @if (Auth::user()->role == 'user' || Auth::user()->role == 'admin')
                                <x-primary-button class="w-full" type="submit">
                                    {{ __('Add To Cart') }}
                                </x-primary-button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
