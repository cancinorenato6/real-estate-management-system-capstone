<?php

namespace App\Http\Controllers;
Use App\Models\Property;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function Home(){
        return view('home');
    }

    public function listings()
    {
        $properties = Property::with('agent')->latest()->paginate(6); // fetch all properties with agent data
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

    // Return the view with the property details
    return view('pubViewProperties', compact('property'));
}

    




  
}
