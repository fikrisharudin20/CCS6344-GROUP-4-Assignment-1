<x-app-layout>
    <x-slot name="header">
        <h2 class="w-fit font-semibold text-xl leading-tight bg-gradient-to-r from-cyan-500 to-purple-500 text-transparent bg-clip-text">
            {{ __('Ticket List') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Alert Message --}}
                    @if (session()->has('success'))
                        <div class="text-center px-4 py-3 mb-4 bg-green-100 border border-green-400 text-green-700 rounded relative">
                            <h5 class="font-semibold">{{ session('success') }}</h5>
                        </div>
                    @endif

                    <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0">
                        {{-- Search Bar --}}
                        <form action="{{ route('tickets.search') }}" method="get" class="flex space-x-2 items-center">
                            <div class="relative">
                                <x-text-input type="text" name="search" placeholder="Event name" class="w-full pl-12"/>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg fill="none" stroke="gray" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                            </div>
                            <x-primary-button type="submit">Search</x-primary-button>
                        </form>

                        
                        <div class="space-y-2 lg:space-x-2 sm:space-y-0">
                            {{-- Filter --}}
                            <x-secondary-button x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'filter')">{{ __('Filter') }}
                            </x-secondary-button>
                            <x-modal name="filter" focusable>
                                <form action="{{ route('tickets.filter') }}" method="get" class="p-6">
                                    {{-- Filter By Date --}}
                                    <section class="space-y-4">
                                        <h2 class="text-lg font-medium text-gray-900">{{ __('Filter By Date') }}</h2>
                                        <div>
                                            <x-input-label for="start_date">Start Date:</x-input-label>
                                            <x-text-input type="date" id="start_date" name="start_date" class="w-full" value="{{ request('start_date') }}" />
                                        </div>
                                        <div>
                                            <x-input-label for="end_date">End Date:</x-input-label>
                                            <x-text-input type="date" id="end_date" name="end_date" class="w-full" value="{{ request('end_date') }}" />
                                        </div>
                                    </section>
                                    <hr class="my-4">
                                
                                    {{-- Sort By --}}
                                    <section class="space-y-4">
                                        <h2 class="text-lg font-medium text-gray-900">{{ __('Sort By') }}</h2>
                                        <div>
                                            <x-input-label value="Event"></x-input-label>
                                            <x-select name="attribute">
                                                <option value="">None</option>
                                                <option value="name">Name</option>
                                                <option value="price">Price</option>
                                                <option value="date">Date</option>
                                                <option value="startTime">Time</option>
                                                <option value="address">Address</option>
                                            </x-select>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <label class="cursor-pointer">
                                                <input type="radio" name="order" value="ASC" checked class="form-radio text-purple-500">
                                                <span class="ml-2 text-gray-700">Ascending</span>
                                            </label>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="order" value="DESC" class="form-radio text-purple-500">
                                                <span class="ml-2 text-gray-700">Descending</span>
                                            </label>
                                        </div>
                                    </section>
                                
                                    <div class="mt-6 flex justify-end">
                                        <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                                        <x-primary-button class="ms-3">Filter</x-primary-button>
                                    </div>
                                </form>
                            </x-modal>
                            
                            {{-- Reset --}}
                            <x-secondary-link href="{{ route('purchased_events.index') }}">Reset</x-secondary-link>
                        </div>
                    </div>

                    {{-- Event Table --}}
                    @if($tickets->isEmpty())
                        <div class="text-center text-gray-500 py-8">
                            <p class="text-lg">No events found.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="table-auto min-w-full mt-4 mb-4">
                                <thead>
                                    <tr class="text-left">
                                        <th class="py-2 px-4 border-b">Event Name</th>
                                        <th class="py-2 px-4 border-b">Address</th>
                                        <th class="py-2 px-4 border-b">Date</th>
                                        <th class="py-2 px-4 border-b">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <td class="py-2 px-4 border-b">{{ $ticket->event->name }}</td>
                                            <td class="py-2 px-4 border-b">{{ $ticket->event->address }}</td>
                                            <td class="py-2 px-4 border-b">{{ date("d F Y", strtotime($ticket->event->date)) }}</td>

                                            <td class="py-2 border-b">
                                                <div class="flex items-center space-x-4">
                                                    <form method="post" action="{{ route('purchased_events.delete', ['purchasedEvent' => $ticket->id]) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit"><x-delete-icon/></button>
                                                    </form>
                                                    <div class="ml-4">
                                                        <x-primary-link :href="route('purchased_events.receipt', ['ticketId' => $ticket->id])">Receipt</x-primary-link>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
