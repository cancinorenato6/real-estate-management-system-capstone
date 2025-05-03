<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
Use App\Models\Property;
Use App\Models\Client;

class ClientsModuleController extends Controller
{
    public function clientsProfile(){
        $client = Auth::guard('client')->user();
        return view('clients.clientsProfile', ['client' => $client]);
    }

    public function clientsListings(Request $request){
        $client = Auth::guard('client')->user();
        $query = Property::query()
        ->with('agent')
        ->where('archived', false);

        if ($request->filled('location')) {
            $query->where(function ($q) use ($request) {
                $q->where('barangay', 'like', '%' . $request->location . '%')
                  ->orWhere('city', 'like', '%' . $request->location . '%')
                  ->orWhere('province', 'like', '%' . $request->location . '%');
            });
        }
    
        // Property Type filter
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }
    
        // Price Range filter
        if ($price = request('price')) {
            // Show properties where price is less than or equal to input
            $query->where('price', '<=', (float) $price);
        
            // Always sort by price ascending
            $query->orderByRaw("CASE WHEN price = ? THEN 0 ELSE 1 END", [(float) $price])
                  ->orderBy('price', 'asc');
        } else {
            // Default sorting if no price filter
            $query->orderBy('price', 'asc');
        }

        $properties = $query->paginate(6);


        // return view('clients.clientsListings', ['client' => $client]);
        return view('clients.clientsListings', compact('properties'));
    }

    // public function favorites(){
    //     $client = Auth::guard('client')->user();
    //     return view('clients.clientsFavorites', ['client' => $client]);
    // }

    // public function clientsFavorites($id)
    // {
    //     $client = Auth::guard('client')->user();
    //     $client = Client::find($id); 
    //     // dd(get_class($client));
    //     $favorites = $client->favorites()->with('agent')->paginate(6);

    //     return view('clients.clientsFavorites', compact('favorites'));
    // }

        public function clientsFavorites()
    {
        $client = Auth::guard('client')->user();
        
        if (!$client) {
            return redirect()->route('clientLogin')->with('error', 'Please login to view your favorites');
        }
        
        $favorites = $client->favorites()->with('agent')->paginate(6);
        return view('clients.clientsFavorites', compact('favorites'));
    }

    public function maps(){
        $client = Auth::guard('client')->user();
        return view('clients.clientsMaps', ['client' => $client]);
    }

    public function messages(){
        $client = Auth::guard('client')->user();
        return view('clients.clientsMessages', ['client' => $client]);
    }

    public function myProperty(){
        $client = Auth::guard('client')->user();
        return view('clients.clientsMyProperty', ['client' => $client]);
    }

        public function clientsViewProperties($id)
    {
        $client = Auth::guard('client')->user();
        // Fetch the property with the given ID and load the related agent (if any)
        $property = Property::with('agent')->findOrFail($id);

        // Return the view with the property details
        return view('clients.clientViewProperties', compact('property'));
    }

    // public function favoriteProperty($propertyId)
    // {
    //     $client = Auth::guard('client')->user();
    
    //     if (!$client) {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }
    //     dd(get_class($client));
    //     $isFavorited = $client->favorites()->where('property_id', $propertyId)->exists();
    
    //     if ($isFavorited) {
    //         $client->favorites()->detach($propertyId);
    //         return response()->json(['favorited' => false]);
    //     } else {
    //         $client->favorites()->attach($propertyId);
    //         return response()->json(['favorited' => true]);
    //     }
    // }

        public function favoriteProperty($propertyId)
    {
        $client = Auth::guard('client')->user();
        
        if (!$client) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $isFavorited = $client->favorites()->where('property_id', $propertyId)->exists();
        
        if ($isFavorited) {
            $client->favorites()->detach($propertyId);
            return response()->json(['favorited' => false]);
        } else {
            $client->favorites()->attach($propertyId);
            return response()->json(['favorited' => true]);
        }
    }


}
