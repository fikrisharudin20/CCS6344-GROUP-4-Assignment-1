<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart; //to ensure cart model corresponding to the carts table
use App\Models\Event; 
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Function to add an event to the cart
    public function store(Request $request)
    {
        // Validate the request if necessary
        // $request->validate([...]);

        // Create a new cart item
        $cartItem = new Cart([
            'user_id' => Auth::id(), // or auth()->id()
            'event_id' => $request->event_id,
        ]);

        // Save the cart item
        $cartItem->save();

        // Redirect back with a success message
        return back()->with('success', 'Event added to cart successfully!');
    }

    // Function to display the cart
    public function index()
    {
        // Get the user's cart items
        $cartItems = Cart::where('user_id', Auth::id())->get();

        // Load a view and pass the cart items to it
        return view('cart.index', compact('cartItems'));
        
        // Get the user's cart items
        $cartItems = Cart::with('event')->where('user_id', Auth::id())->get();

    // Load a view and pass the cart items to it
    return view('cart', compact('cartItems'));

    }

 

    public function remove($cartItemId) {
        // Find the cart item by id and delete it
        Cart::where('id', $cartItemId)->delete();

        // Redirect back to the cart page with a success message
        return back()->with('success', 'Item removed from cart.');
    }
    // for adding other necessary methods, like remove from cart, update quantity, etc.
}
