<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout.index');
    }


    public function store(Request $request)
    {
        // Handle the checkout process here
        // Save the order details, clear the cart, send confirmation email, etc.
        //
        
        // Redirect to a thank you page or order summary
        return redirect()->route('orders.thankyou'); 
    }
    

}
