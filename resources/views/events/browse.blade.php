<x-app-layout>
    <x-slot name="header">
        <h2 class="w-fit font-semibold text-xl leading-tight bg-gradient-to-r from-cyan-500 to-purple-500 text-transparent bg-clip-text">
            {{ __('Browse Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Error Message --}}
                    @if ($errors->any())
                    <div class="text-center px-4 py-3 mb-4 bg-red-100 border border-red-400 text-red-700 rounded relative">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if(session('error'))
                        <div class="text-center px-4 py-3 mb-4 bg-red-100 border border-red-400 text-red-700 rounded relative">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="flex flex-col lg:flex-row justify-between space-y-2 lg:space-y-0">
                        {{-- Search Bar --}}
                        <form action="{{ route('events.search') }}" method="get" class="flex space-x-2 items-center">
                            <div class="relative">
                                <x-text-input type="text" name="search" placeholder="Event name" class="w-full pl-12"/>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg fill="none" stroke="gray" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                            </div>
                            <x-primary-button type="submit">Search</x-primary-button>
                        </form>

                        <div class="space-y-2 lg:space-x-2 sm:space-y-0">
                            {{-- Find Nearby --}}
                            <x-secondary-button x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'find_nearby')">{{ __('Find Nearby') }}
                            </x-secondary-button>
                            <x-modal name="find_nearby" focusable>
                                <form action="{{ route('events.findNearby') }}" method="get" class="p-6">
                                    <h2 class="text-lg font-medium text-gray-900">
                                        {{ __('Find Nearby Event') }}
                                    </h2>
                                    <br>
                                    <x-input-label value="Location"/> 
                                    <x-text-input id="address" type="text" name="location" placeholder="Enter location..." class="w-full"/>
                                    <br><br>
                                    <x-input-label value="Distance (KM)"/>
                                    <x-select name="distance">
                                        <option value="15">15</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                    </x-select>
                                    <div>
                                        <div id="map" class="hidden"></div> 
                                    </div>
                                    <br>
                                    {{-- <x-text-input type='text' id='location' /> --}}
                                    <div class="mt-6 flex justify-end">
                                        <x-secondary-button x-on:click="$dispatch('close')">
                                            {{ __('Cancel') }}
                                        </x-secondary-button>
                                        <x-primary-button class="ms-3">
                                            {{ __('Find') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                            </x-modal>

                            {{-- Filter --}}
                            <x-secondary-button x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'filter')">{{ __('Filter') }}
                            </x-secondary-button>
                            <x-modal name="filter" focusable>
                                <form action="{{ route('events.filter') }}" method="get" class="p-6">

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
                                
                                    {{-- Filter By Price --}}
                                    <section class="space-y-4">
                                        <h2 class="text-lg font-medium text-gray-900">{{ __('Filter By Price') }}</h2>
                                        <div>
                                            <x-input-label for="min_price">Minimum Price:</x-input-label>
                                            <x-text-input id="min_price" name="min_price" class="w-full" pattern="^\d*(\.\d{0,2})?$" value="{{ request('min_price') }}" />
                                        </div>
                                        <div>
                                            <x-input-label for="max_price">Maximum Price:</x-input-label>
                                            <x-text-input id="max_price" name="max_price" class="w-full" pattern="^\d*(\.\d{0,2})?$" value="{{ request('max_price') }}" />
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
                            <x-secondary-link href="{{ route('events.browse') }}">Reset</x-secondary-link>
                        </div>
                    </div>

                    {{-- Event Table --}}
                    @if($events->isEmpty())
                        <div class="text-center text-gray-500 py-8">
                            <p class="text-lg">No events found.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="table-auto min-w-full mt-4 mb-4 ">
                                <thead>
                                    <tr class="text-left">
                                        <th class="py-2 px-4 border-b">Name</th>
                                        <th class="py-2 px-4 border-b hidden md:table-cell">Address</th>
                                        <th class="py-2 px-4 border-b hidden md:table-cell">Date</th>
                                        <th class="py-2 px-4 border-b hidden md:table-cell whitespace-nowrap">Price (RM)</th>
                                        <th class="py-2 px-4 border-b">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($events as $event)
                                        <tr>
                                            <td class="py-2 px-4 border-b">{{ $event->name }}</td>
                                            <td class="py-2 px-4 border-b hidden md:table-cell">{{ $event->address }}</td>
                                            <td class="py-2 px-4 border-b hidden md:table-cell">{{ date("d F Y", strtotime($event->date) )}}</td>
                                            <td class="py-2 px-4 border-b hidden md:table-cell">{{ $event->price }}</td>
                                            <td class="py-2 px-4 border-b">
                                                <x-primary-link
                                                href="{{route('events.view',['event'=> $event])}}">Details</x-primary-link>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- Pagination --}}
                            {{ $events->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
