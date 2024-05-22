<x-app-layout>
    <x-slot name="header">
        <h2 class="w-fit font-semibold text-xl leading-tight bg-gradient-to-r from-cyan-500 to-purple-500 text-transparent bg-clip-text">
            {{ __('Digital Receipt') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <div class="flex justify-center">
            <div class="max-w-lg bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h2 class="text-xl font-semibold mb-4">Payment Receipt</h2>
                <hr class="mb-4">
                
                {{-- Payment Information --}}
                <div class="mb-6">
                    <div class="mb-4">
                        <p class="font-semibold">Payment ID:</p>
                        <p>{{ $ticket->paymentID }}</p>
                    </div>

                <hr class="mb-6 border-t-2 border-dotted border-gray-400">



                {{-- Ticket Information --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Ticket Information</h3>
                    <div class="mb-4">
                        <p class="font-semibold">Ticket ID:</p>
                        <p>{{ $ticket->id }}</p>
                    </div>

                <hr class="mb-6 border-t-2 border-dotted border-gray-400">

                {{-- User Information --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">User Information</h3>
                    <div class="mb-4">
                        <p class="font-semibold">User ID:</p>
                        <p>{{ $ticket->user->id }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-semibold">Name:</p>
                        <p>{{ $ticket->user->name }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-semibold">Email:</p>
                        <p>{{ $ticket->user->email }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-semibold">Phone:</p>
                        <p>{{ $ticket->user->phone }}</p>
                    </div>
                </div>

                <hr class="mb-6 border-t-2 border-dotted border-gray-400">

                {{-- Event Information --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Event Information</h3>
                    <div class="mb-4">
                        <p class="font-semibold">Event ID:</p>
                        <p>{{ $ticket->event->id }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-semibold">Event Name:</p>
                        <p>{{ $ticket->event->name }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-semibold">Event Price:</p>
                        <p>{{ $ticket->event->price }}</p>
                    </div>
                </div>

                <hr class="mb-6 border-t-2 border-dotted border-gray-400">

                {{-- Payment Information --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Payment Information</h3>
                    <div class="mb-4">
                        <p class="font-semibold">Payment ID:</p>
                        <p>{{ $ticket->payment->id }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-semibold">Card Name:</p>
                        <p>{{ $ticket->payment->card_name }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-semibold">Address:</p>
                        <p>{{ $ticket->payment->address }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-semibold">City:</p>
                        <p>{{ $ticket->payment->city }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-semibold">State:</p>
                        <p>{{ $ticket->payment->state }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-semibold">Postal Code:</p>
                        <p>{{ $ticket->payment->postal_code }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-semibold">Country:</p>
                        <p>{{ $ticket->payment->country }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-semibold">Card Number:</p>
                        <p>************{{ substr($ticket->payment->card_number, -4) }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-semibold">Card Expiration:</p>
                        <p>{{ $ticket->payment->card_expiration }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="font-semibold">Card CVC:</p>
                        <p>****</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
</x-app-layout>

<!-- Floating Footer Buttons -->
<div id="footerButtons" class="fixed bottom-0 right-0 bg-transparent py-4 hidden mr-4 mb-4">
    <div>
        <!-- Download PDF Button -->
        <button onclick="downloadPDF()" class="bg-gradient-to-r from-blue-300 to-blue-500 hover:from-blue-400 hover:to-blue-600 text-white font-bold py-2 px-4 rounded mr-2">
            Download PDF
        </button>

        <!-- Print Button -->
        <button onclick="window.print()" class="bg-gradient-to-r from-green-300 to-green-500 hover:from-green-400 hover:to-green-600 text-white font-bold py-2 px-4 rounded mr-2">
            Print
        </button>

        <!-- Share Button (Example) -->
        <button onclick="share()" class="bg-gradient-to-r from-gray-300 to-gray-500 hover:from-gray-400 hover:to-gray-600 text-white font-bold py-2 px-4 rounded">
            Share
        </button>
    </div>
</div>

<script>
    function downloadPDF() {
        // Logic to download PDF
        alert('PDF downloaded!');
    }
    
    function share() {
        // Logic to share receipt (e.g., via email, social media)
        alert('Receipt shared!');
    }

    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("footerButtons").classList.remove('hidden');
        } else {
            document.getElementById("footerButtons").classList.add('hidden');
        }
    }
</script>
