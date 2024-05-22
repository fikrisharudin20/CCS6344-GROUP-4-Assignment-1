<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Ticket; // Import the Ticket model
use App\Models\Event;
use Carbon\Carbon;

class PurchasedEventController extends Controller 
{
    public function index()
    {
        // Assuming you have logic to retrieve tickets instead of purchased events
        $tickets = Ticket::all();

        // Return view with the data
        return view('purchased_events.index', ['tickets' => $tickets]);
    }
    

    // Delete purchased event
    public function delete(Ticket $ticket) // Adjust the type hint to Ticket model
    {
        $ticket->delete(); // Update the deletion operation
        return redirect()->route('purchased_events.index')->with('success', 'Ticket Deleted Successfully');
    }

    // View digital receipt
    public function receipt($ticketId)
    {
        // Retrieve the ticket based on the selected ticket ID
        $ticket = Ticket::with(['user', 'event', 'payment'])->findOrFail($ticketId);

        // Return view with the data
        return view('purchased_events.receipt', ['ticket' => $ticket]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required|max:255',
        ]);
        
        $search = $request->input('search');

        $tickets = Ticket::whereHas('event', function ($query) use ($search) {
            $query->where('name', $search);
        })->get();

        return view('purchased_events.index', compact('tickets'));
    }

    public function filter(Request $request)
    {
        $tickets = Ticket::query();

        // filter date date from start to end
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();

            $tickets = Ticket::whereHas('event', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            })->get();
        }

        // sort by the attribute of the events
        $attribute = $request->input('attribute');
        $order = $request->input('order');
        if ($attribute) {
            $tickets->orderBy($attribute, $order)->get();
        }

        return view('purchased_events.index', compact('tickets'));
    }
}
