<x-app-layout>
    <x-slot name="header">
        <h2 class="w-fit font-semibold text-xl leading-tight bg-gradient-to-r from-cyan-500 to-purple-500 text-transparent bg-clip-text">
            {{ __('View Events') }}
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

                    <x-primary-link href="{{ route('events.create') }}" class="create-event-button mb-4">Create New Event</x-primary-link>

                    <div class="flex flex-col lg:flex-row justify-between space-y-2 lg:space-y-0">
                        {{-- Search Bar --}}
                        <form action="{{ route('events.searchAll') }}" method="get" class="flex space-x-2 items-center">
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
                                <form action="{{ route('events.filterAll') }}" method="get" class="p-6">

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
                            <x-secondary-link href="{{ route('events.allEvents') }}">Reset</x-secondary-link>
                        </div>
                    </div>

                    {{-- Event Table --}}
                    @if ($events->isEmpty())
                        <div class="text-center text-gray-500 py-8">
                            <p class="text-lg">No events found.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="table-auto min-w-full mt-4 mb-4">
                                <thead>
                                    <tr class="text-left">
                                        <th class="py-2 px-4 border-b">Name</th>
                                        <th class="py-2 px-4 border-b">Address</th>
                                        <th class="py-2 px-4 border-b">Date</th>
                                        <th class="py-2 px-4 border-b hidden md:table-cell whitespace-nowrap">Price (RM)</th>
                                        <th class="py-2 px-4 border-b" colspan="3">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($events as $event)
                                        <tr>
                                            <td class="py-2 px-4 border-b">{{ $event->name }}</td>
                                            <td class="py-2 px-4 border-b">{{ $event->address }}</td>
                                            <td class="py-2 px-4 border-b">{{ date('d F Y', strtotime($event->date)) }}
                                            </td>
                                            <td class="py-2 px-4 border-b">{{ $event->price }}</td>
                                            <td class="py-2 pl-4 border-b">
                                                <a class="w-fit h-fit" href="{{ route('events.edit', ['event' => $event]) }}">
                                                    <x-edit-icon/>
                                                </a>
                                            </td>                                            
                                            <td class="py-2 border-b">
                                                <form class="w-fit h-fit" method="post" action="{{ route('events.delete', ['event' => $event]) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="hidden"><x-delete-icon/></button>
                                                </form>
                                            </td>                                            
                                            <td class="py-2 pr-4 border-b">
                                                <x-primary-link
                                                href="{{route('events.view',['event'=> $event])}}">Details</x-primary-link>
                                            </td>                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- Display Pagination Links --}}
                            {{ $events->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
