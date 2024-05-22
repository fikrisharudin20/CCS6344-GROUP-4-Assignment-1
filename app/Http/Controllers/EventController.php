<?php

namespace App\Http\Controllers;

use Geocoder\Laravel\ProviderAndDumperAggregator as Geocoder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    // return all events
    public function allEvents()
    {
        // if admin, show all events. else, show event that only the user created
        if (Auth::user()->role == 'admin') {
            $events = Event::query()->paginate(5);
        } else {
            $userID = Auth::id();
            $events = Event::where('userID', $userID)->paginate(5);
        }
    
        return view('events.allEvents', ['events' => $events]);
    }

    // create events page
    public function create()
    {
        return view('events.create');
    }

    // store events when created
    public function store(Request $request, Geocoder $geocoder)
    {
        $data = $request->validate([
            'name'=> 'required',
            'date'=> 'date',
            'startTime'=> 'required',
            'endTime'=> 'required',
            'address'=> 'required',
            'description'=> 'nullable',
            'price'=> 'required | decimal:0,2',
        ]);

        $address = $request->input('address');

        // get the geocode of the entered address
        try {
            $result = $geocoder->geocode($address)->get()->first();
        
            if ($result) {
                $coordinates = $result->getCoordinates();
            } else {
                return redirect()->route('events.create')->with('error', 'Address is invalid.');
            }
        } catch (\Exception $e) {
            return redirect()->route('events.create')->with('error', 'Address is invalid.');
        }
        
        // set the coordinate in the google map
        $data['address'] = $address;
        $data['lat'] = $coordinates->getLatitude();
        $data['long'] = $coordinates->getLongitude();

        // Check if user is authenticated
        if (auth()->check()) {
            $data['userID'] = Auth::id();

            Event::create($data);

            return redirect(route('events.allEvents'));
        } else {
            return redirect()->route('login')->with('error', 'Please log in to create an event.');
        }
    }

    // return edit event page
    public function edit(Event $event)
    {
        return view('events.edit', ['event' => $event]);
    }

    // update event data
    public function update(Event $event, Request $request, Geocoder $geocoder)
    {
        $data = $request->validate([
            'name' => 'required',
            'date' => 'date',
            'startTime' => 'required',
            'endTime' => 'required',
            'address' => 'required',
            'description' => 'nullable',
            'price' => 'required | decimal:0,2',
        ]);

        $address = $request->input('address');

        // get the geocode of the entered address
        try {
            $result = $geocoder->geocode($address)->get()->first();
        
            if ($result) {
                $coordinates = $result->getCoordinates();
            } else {
                return redirect()->route('events.create')->with('error', 'Address is invalid.');
            }
        } catch (\Exception $e) {
            return redirect()->route('events.create')->with('error', 'Address is invalid.');
        }
        
        // set the coordinate in the google map
        $data['address'] = $address;
        $data['lat'] = $coordinates->getLatitude();
        $data['long'] = $coordinates->getLongitude();

        $event->update($data);

        return redirect(route('events.allEvents'))->with('success', 'Event Updated Successfully');
    }

    // delete event
    public function delete(Event $event)
    {
        $event->delete();
        return redirect(route('events.allEvents'))->with('success', 'Event Deleted Successfully');
    }

    // browse all events
    public function browse(Request $request)
    {
        // get all events
        $query = Event::query();
        
        // pagination and display only 5 row in the table
        $events = $query->paginate(5);

        return view('events.browse', compact('events'));
    }

    // search event by its name
    public function search(Request $request)
    {
        // validation
        $request->validate([
            'search' => 'required|max:255',
        ]);

        $query = Event::query();
        
        // get input value from the view file
        $search = $request->input('search');

        // get matching event with the search query
        if ($search) {
            $query->where('name', 'like', "%$search%");
        }

        $events = $query->paginate(5);

        return view('events.browse', compact('events'));
    }

    // find nearby event by location and the approximate distance
    public function findNearby(Request $request, Geocoder $geocoder)
    {
        $query = Event::query();

        $location = $request->input('location');
        $distance = $request->input('distance');

        if ($location && $distance) 
        {
            // get the geocode of the entered address
            try {
                $result = $geocoder->geocode($location)->get()->first();
            
                if ($result) {
                    $coordinates = $result->getCoordinates();
                } else {
                    return redirect()->route('events.browse')->with('error', 'Address is invalid.');
                }
            } catch (\Exception $e) {
                return redirect()->route('events.browse')->with('error', 'Address is invalid.');
            }

            // set the latitude and longitude of the location
            $lat = $coordinates->getLatitude();
            $long = $coordinates->getLongitude();
            
            // haversine formula to calculate distance
            $haversine = "(6371 * acos(cos(radians($lat)) * cos(radians(`lat`)) * cos(radians(`long`) - radians($long)) + sin(radians($lat)) * sin(radians(`lat`))))";

            // query to get nearby events within the specified distance
            $query = Event::select('*')
                ->selectRaw("$haversine AS distance")
                ->whereRaw("$haversine < ?", [$distance])
                ->orderBy('distance');

        }

        $events = $query->paginate(5);

        return view('events.browse', compact('events'));
    }

    // filter by range of date, price and sort by an attribute of events
    public function filter(Request $request)
    {
        $query = Event::query();

        // filter date date from start to end
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();

            $query->whereBetween('date', [$startDate, $endDate]);
        }

        // filter price from mim to max
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }

        // sort by the attribute of the events
        $attribute = $request->input('attribute');
        $order = $request->input('order');
        if ($attribute) {
            $query->orderBy($attribute, $order)->get();
        }

        $events = $query->paginate(5);

        return view('events.browse', compact('events'));
    }

    // view details of an event
    public function view(Event $event)
    {
        return view('events.view', ['event' => $event]);
    }

    // search event by its name
    public function searchAll(Request $request)
    {
        // validation
        $request->validate([
            'search' => 'required|max:255',
        ]);

        // if admin, show all events. else, show event that only the user created
        if (Auth::user()->role == 'admin') {
            $query = Event::query();
        } else {
            $userID = Auth::id();
            $query = Event::where('userID', $userID);
        }
        
        // get input value from the view file
        $search = $request->input('search');

        // get matching event with the search query
        if ($search) {
            $query->where('name', 'like', "%$search%");
        }

        $events = $query->paginate(5);

        return view('events.allEvents', compact('events'));
    }

    // filter by range of date, price and sort by an attribute of events
    public function filterAll(Request $request)
    {
        // if admin, show all events. else, show event that only the user created
        if (Auth::user()->role == 'admin') {
            $query = Event::query();
        } else {
            $userID = Auth::id();
            $query = Event::where('userID', $userID);
        }

        // filter date date from start to end
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();

            $query->whereBetween('date', [$startDate, $endDate]);
        }

        // filter price from mim to max
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }

        // sort by the attribute of the events
        $attribute = $request->input('attribute');
        $order = $request->input('order');
        if ($attribute) {
            $query->orderBy($attribute, $order)->get();
        }

        $events = $query->paginate(5);

        return view('events.allEvents', compact('events'));
    }

}
