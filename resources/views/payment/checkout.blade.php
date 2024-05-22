<x-app-layout>
    <x-slot name="header">
        <h2
            class="w-fit font-semibold text-xl leading-tight bg-gradient-to-r from-cyan-500 to-purple-500 text-transparent bg-clip-text">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('payment.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <h1 class="text-xl font-bold mb-2 col-span-2">Card Details</h1>
                            <div class="mb-4 col-span-2 md:col-span-1">
                                <x-input-label for="card_number">Credit Card</x-input-label>
                                <x-text-input type="text" id="card_number" name="card_number" placeholder="Card number" class="w-full" required />
                            </div>
                            <div class="md:flex mb-4 col-span-2 md:col-span-1">
                                <div class="mb-6 md:mb-0 md:mr-2 w-full">
                                    <x-input-label for="card_expiration">Expiration Date (MM / YY)</x-input-label>
                                    <x-text-input type="text" id="card_expiration" name="card_expiration" placeholder="MM / YY" class="w-full" required />
                                </div>
                                <div class="md:ml-2 w-full">
                                    <x-input-label for="card_cvc">Security Code</x-input-label>
                                    <x-text-input type="text" id="card_cvc" name="card_cvc" placeholder="CVC" class="w-full" required />
                                </div>
                            </div>
                            <div class="mb-4 col-span-2 md:col-span-1">
                                <x-input-label for="card_name">Name on Card</x-input-label>
                                <x-text-input type="text" id="card-name" name="card_name" placeholder="Name on card" class="w-full" required />
                            </div>
                            <hr class="col-span-2 m-2">
                            <h1 class="text-xl font-bold mb-2 col-span-2">Billing Address</h1>
                            <div class="col-span-2">
                                <x-input-label for="address">Address*</x-input-label>
                                <x-text-input type="text" id="address" name="address" class="w-full" required />
                            </div>
                            <div>
                                <x-input-label for="city">City*</x-input-label>
                                <x-text-input type="text" id="city" name="city" class="w-full" required />
                            </div>
                            <div>
                                <x-input-label for="state">State*</x-input-label>
                                <x-text-input type="text" id="state" name="state" class="w-full" required />
                            </div>
                            <div>
                                <x-input-label for="postal_code">Postal Code*</x-input-label>
                                <x-text-input type="text" id="postal_code" name="postal_code" class="w-full" required />
                            </div>
                            <div>
                                <x-input-label for="country">Country*</x-input-label>
                                <x-text-input type="text" id="country" name="country" class="w-full" required />
                            </div>
                        </div>
                        <div class="mt-6 flex space-x-4 justify-end">
                            <x-secondary-button type="button" onclick="window.history.back()">Cancel</x-secondary-button>
                            <x-primary-button type="submit">Pay Now</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
