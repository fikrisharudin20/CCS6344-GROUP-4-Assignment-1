<x-app-layout>
    <x-slot name="header">
        <h2 class="w-fit font-semibold text-xl leading-tight bg-gradient-to-r from-cyan-500 to-purple-500 text-transparent bg-clip-text">
            {{ __('Update Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
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
                    
                    <div class="grid grid-cols-1 md:gap-x-4 md:grid-cols-2">
                        <form method='post' action="{{ route('events.update', ['event' => $event]) }}">
                            @csrf
                            @method('PUT')
                    
                            <div class="mb-4">
                                <x-input-label>Event Name</x-input-label>
                                <x-text-input type='text' name='name'  class="w-full" value="{{ $event->name }}"/>
                            </div>
                            <div class="mb-4">
                                <x-input-label>Date</x-input-label>
                                <x-text-input type='date' name='date' class="w-full" value="{{ $event->date }}"/>
                            </div>
                            <div class="mb-4">
                                <x-input-label>Start time</x-input-label>
                                <x-text-input type='time' name='startTime' class="w-full" value="{{ $event->startTime }}"/>
                            </div>
                            <div class="mb-4">
                                <x-input-label>End time</x-input-label>
                                <x-text-input type='time' name='endTime' class="w-full" value="{{ $event->endTime }}"/>
                            </div>
                            <div class="mb-4">
                                <x-input-label>Address</x-input-label>
                                <x-text-input id="address" type="text" name="address" placeholder="Search location..." class="w-full" value="{{ $event->address }}"/>
                            </div>
                            <div class="mb-4">
                                <x-input-label>Description</x-input-label>
                                <x-text-area type='text' name='description' class="w-full" value="{{ $event->description }}"/>
                            </div>
                            <div class="mb-8">
                                <x-input-label>Price</x-input-label>
                                <x-text-input pattern="^\d*(\.\d{0,2})?$" name='price' class="w-full" value="{{ $event->price }}"/>
                            </div>
                    
                            <div class="flex space-x-4 mb-4 md:mb-0">
                                <x-secondary-button type="button" class="w-full" onclick="window.history.back()">
                                    Cancel
                                </x-secondary-button>
                                <x-primary-button type="submit" class="w-full">Update</x-primary-button>
                            </div>
                            
                        </form>
                        <div>
                            <div id="map" class="w-full h-screen md:w-full md:h-full rounded-md"></div> 
                        </div>
                    </div>
                            
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
