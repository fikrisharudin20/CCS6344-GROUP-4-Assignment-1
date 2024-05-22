<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\Ticket;
use App\Notifications\PaymentNotification;

class PaymentController extends Controller
{
    public function checkout()
    {
        // You can pass order details to the view if needed
        return view('payment.checkout');
    }

    public function store(Request $request)
    {
        // ... process the payment ...

        // Validate the request data
        $validatedData = $request->validate([
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'card_number' => 'required|string|max:255',
            'card_expiration' => 'required|string|max:255',
            'card_cvc' => 'required|string|max:255',
            'card_name' => 'required|string|max:255',
        ]);

        // Create and save the order to the database
        $payment = Payment::create($validatedData);

        // Handle the post-order logic (e.g., clear cart, send confirmation email)
        if ($payment) {
            $carts = Cart::where('user_id', auth()->id())->get();
            
            foreach ($carts as $cart) {
                // Move item in cart to table Ticket with the payment ID
                $ticket = Ticket::create([
                    'userID' => $cart->user_id,
                    'eventID' => $cart->event_id,
                    'paymentID' => $payment->id,
                ]);
                
                // Notify the organiser via email
                $organiser = $ticket->event->user;
                $organiser->notify(new PaymentNotification($ticket));
            };
            
            // Order has been saved successfully, now clear the cart.
            $carts = Cart::where('user_id', auth()->id())->delete();

            // If payment is successful, redirect to the thank you page
            return redirect()->route('payment.success')->with('success', 'Thank you for your payment.');
        } else {
            // If the order wasn't saved successfully, redirect back with an error message
            return back()->withErrors('There was an issue with the payment. Please try again.');
        }
    }

    public function success()
    {
        // You can pass order details to the view if needed
        return view('payment.thankyou');
    }
}
