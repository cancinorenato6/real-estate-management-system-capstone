<?php

namespace App\Http\Controllers;
Use App\Models\Property;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    // public function Home(){
    //     return view('home');
    // }

        public function home()
    {
        $properties = Property::with('agent')
                        ->where('archived', false) // Load related agent
                        ->latest()            // Order by created_at DESC
                        ->take(3)             // Limit to 3 properties
                        ->get();

        return view('home', compact('properties'));
    }

    // public function listings()
    // {
    //     $properties = Property::with('agent')->latest()->paginate(6); // fetch all properties with agent data
    //     return view('listings', compact('properties'));
    // }

    public function listings(Request $request)
{
    $query = Property::query()
    ->with('agent')
    ->where('archived', false);
    
    // Location filter
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



    $properties = $query->paginate(9); // adjust number if needed

    return view('listings', compact('properties'));
}

    public function Services(){
        return view('services');
    }

    public function About(){
        return view('about');
    }

    public function pubViewProperties($id)
{
    // Fetch the property with the given ID and load the related agent (if any)
    $property = Property::with('agent')->findOrFail($id);
    $similarProperties = Property::where('city', $property->city)
    ->where('id', '!=', $property->id)
    ->take(3)
    ->get(); // Example for similar properties

    // Return the view with the property details
    return view('pubViewProperties', compact('property', 'similarProperties'));
}


  


    




  
}
