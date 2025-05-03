<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Client;
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

    // public function agentMessages(){
    //     $agent = Auth::guard('agent')->user();
    //     return view('agents.agentMessages', ['agent' => $agent]);
    // }

    // public function agentMessages()
    // {
    //     $agent = Auth::guard('agent')->user();
    //     // Fetch unique conversations grouped by property and client
    //     $conversations = Message::where('agent_id', $agent->id)
    //         ->with(['property', 'client'])
    //         ->select('property_id', 'client_id')
    //         ->distinct()
    //         ->get()
    //         ->map(function ($message) {
    //             return [
    //                 'property' => $message->property,
    //                 'client' => $message->client,
    //                 'last_message' => Message::where('property_id', $message->property_id)
    //                     ->where('client_id', $message->client_id)
    //                     ->where('agent_id', $message->client->id)
    //                     ->latest()
    //                     ->first(),
    //             ];
    //         });
    //     return view('agents.agentMessages', compact('agent', 'conversations'));
    // }

    // public function viewConversation($property_id, $client_id)
    // {
    //     $agent = Auth::guard('agent')->user();
    //     $property = Property::findOrFail($property_id);
    //     $client = Client::findOrFail($client_id);
    //     $messages = Message::where('property_id', $property_id)
    //         ->where('client_id', $client_id)
    //         ->where('agent_id', $agent->id)
    //         ->orderBy('created_at', 'asc')
    //         ->get();
    //     // Mark messages as read
    //     Message::where('property_id', $property_id)
    //         ->where('client_id', $client_id)
    //         ->where('agent_id', $agent->id)
    //         ->where('sender_type', 'client')
    //         ->update(['is_read' => true]);
    //     return view('agents.agentConversation', compact('agent', 'property', 'client', 'messages'));
    // }

    // public function sendMessage(Request $request)
    // {
    //     $request->validate([
    //         'property_id' => 'required|exists:properties,id',
    //         'client_id' => 'required|exists:clients,id',
    //         'message' => 'required|string|max:2000',
    //     ]);

    //     $agent = Auth::guard('agent')->user();
    //     Message::create([
    //         'property_id' => $request->property_id,
    //         'client_id' => $request->client_id,
    //         'agent_id' => $agent->id,
    //         'message' => $request->message,
    //         'sender_id' => $agent->id,
    //         'sender_type' => 'agent',
    //     ]);

    //     return response()->json(['success' => true, 'message' => 'Message sent successfully']);
    // }

    public function agentMessages()
    {
        $agent = Auth::guard('agent')->user();
        $conversations = Message::where('agent_id', $agent->id)
            ->with(['property', 'client'])
            ->select('property_id', 'client_id')
            ->distinct()
            ->get()
            ->map(function ($message) use ($agent) {
                return [
                    'property' => $message->property,
                    'client' => $message->client,
                    'last_message' => Message::where('property_id', $message->property_id)
                        ->where('agent_id', $agent->id)
                        ->where('client_id', $message->client_id)
                        ->latest()
                        ->first(),
                    'has_unread' => Message::where('property_id', $message->property_id)
                        ->where('agent_id', $agent->id)
                        ->where('client_id', $message->client_id)
                        ->where('sender_type', 'client')
                        ->where('is_read', false)
                        ->exists(),
                ];
            })
            ->sortByDesc(function ($conversation) {
                return $conversation['last_message'] ? $conversation['last_message']->created_at : '2000-01-01';
            });

        $total_unread = $conversations->filter(function ($conversation) {
            return $conversation['has_unread'];
        })->count();

        return view('agents.agentMessages', compact('agent', 'conversations', 'total_unread'));
    }

    public function viewConversation($property_id, $client_id)
    {
        $agent = Auth::guard('agent')->user();
        $property = Property::findOrFail($property_id);
        $client = Client::findOrFail($client_id);

        $updatedCount = Message::where('property_id', $property_id)
            ->where('client_id', $client_id)
            ->where('agent_id', $agent->id)
            ->where('sender_type', 'client')
            ->where('is_read', false)
            ->update(['is_read' => true]);
        \Log::info("Marked $updatedCount messages as read for agent {$agent->id}, property {$property_id}, client {$client_id}");

        $messages = Message::where('property_id', $property_id)
            ->where('client_id', $client_id)
            ->where('agent_id', $agent->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('agents.agentConversation', compact('agent', 'property', 'client', 'messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'client_id' => 'required|exists:clients,id',
            'message' => 'required|string|max:2000',
        ]);

        $agent = Auth::guard('agent')->user();
        Message::create([
            'property_id' => $request->property_id,
            'client_id' => $request->client_id,
            'agent_id' => $agent->id,
            'message' => $request->message,
            'sender_id' => $agent->id,
            'sender_type' => 'agent',
        ]);

        return response()->json(['success' => true, 'message' => 'Message sent successfully']);
    }



    public function agentProperties() {
        $agent = Auth::guard('agent')->user();
        $properties = Property::where('agent_id', $agent->id)
                              ->where('archived', false)
                              ->get();
    
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
    // public function agentArchiveProperties(){
    //     $agent = Auth::guard('agent')->user();
    //     return view('agents.agentArchiveProperties', ['agent' => $agent]);
    // }

    public function archive($id) {
        $property = Property::findOrFail($id);
        
        // Check if the authenticated agent owns the property
        if ($property->agent_id != Auth::guard('agent')->id()) {
            abort(403); // unauthorized
        }
    
        $property->archived = true;
        $property->save();
    
        return redirect()->back()->with('success', 'Property archived successfully!');
    }

    public function agentArchiveProperties() {
        $agent = Auth::guard('agent')->user();
        $archivedProperties = Property::where('agent_id', $agent->id)
                                      ->where('archived', true)
                                      ->get();
    
        return view('agents.agentArchiveProperties', compact('archivedProperties'));
    }

        public function restoreProperty($id)
    {
        $property = Property::findOrFail($id);

        if ($property->archived) {
            $property->archived = false;
            $property->save();

            return redirect()->back()->with('success', 'Property restored successfully.');
        }

        return redirect()->back()->with('error', 'Property is not archived.');
    }

    
    



    


}

