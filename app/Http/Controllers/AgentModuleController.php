<?php

namespace App\Http\Controllers;

Use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AgentModuleController extends Controller
{
    public function agentDashboard(){
        $agent = Auth::guard('agent')->user();
        return view('agents.agentDashboard', ['agent' => $agent]);
    }

    public function agentProperties(){
        $agent = Auth::guard('agent')->user();
        $properties = Property::where('agent_id', $agent->id)->with('agent')->get();
        // return view('agents.agentProperties', ['agent' => $agent]);
        return view('agents.agentProperties', compact('properties'));
    }

    public function createProperty(){
        return view('agents.createProperty');
    }

    public function storeProperty(Request $request){
        $request->validate([
            'offer_type' => 'required|in:sell,rent',
            'property_type' => 'required|in:condominium,commercial_space,apartment,house,land',
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'province' => 'required',
            'city' => 'required',
            'barangay' => 'required',
            'images.*' => 'image', // each image max 2MB
        ]);

        $agent = Auth::guard('agent')->user();
        $imagePaths = [];

        if($request->hasFile('images')) {
            foreach($request->file('images') as $image) {
                $path = $image->store('properties', 'public');
                $imagePaths[] = $path;
            }
        }

        Property::create([
            'agent_id' => $agent->id,
            'offer_type' => $request->offer_type,
            'property_type' => $request->property_type,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'province' => $request->province,
            'city' => $request->city,
            'barangay' => $request->barangay,
            'images' => $imagePaths,
        ]);

        return redirect()->route('agentProperties')->with('success', 'Property added successfully.');
    }

    public function editProperty($id){
        $property = Property::findOrFail($id);

        return view('agents.editProperty', compact('property'));
    }

    public function updateProperty(Request $request, $id){
        $property = Property::findOrFail($id);

        $request->validate([
            'offer_type' => 'required|in:sell,rent',
            'property_type' => 'required|in:condominium,commercial_space,apartment,house,land',
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'province' => 'required',
            'city' => 'required',
            'barangay' => 'required',
            'images.*' => 'image',
        ]);

        $imagePaths = $property->images ?? [];

        if($request->hasFile('images')) {
            foreach($request->file('images') as $image) {
                $path = $image->store('properties', 'public');
                $imagePaths[] = $path;
            }
        }

        $property->update([
            'offer_type' => $request->offer_type,
            'property_type' => $request->property_type,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'province' => $request->province,
            'city' => $request->city,
            'barangay' => $request->barangay,
            'images' => $imagePaths,
        ]);

        $property->save();

        return redirect()->route('agentProperties')->with('success', 'Property updated successfully.');
    }

    public function deleteProperty($id){
        $property = Property::findOrFail($id);

        // Optionally delete images from storage too
        if ($property->images) {
            foreach ($property->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $property->delete();

        return redirect()->route('agents.agentProperties')->with('success', 'Property deleted successfully.');
    }

    public function viewProperties($id)
{
    $property = Property::with('agent')->findOrFail($id);
    return view('agents.viewProperties', compact('property'));
}

    public function agentSoldProperties(){
        $agent = Auth::guard('agent')->user();
        return view('agents.agentSoldProperties', ['agent' => $agent]);
    }
    public function agentArchiveProperties(){
        $agent = Auth::guard('agent')->user();
        return view('agents.agentArchiveProperties', ['agent' => $agent]);
    }
    


}

