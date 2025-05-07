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


    public function agentViewClients(){
        $agent = Auth::guard('agent')->user();
        return view('agents.agentViewClients', ['agent' => $agent]);
    }

   public function agentAccount()
{
    $agent = Auth::guard('agent')->user();
    return view('agents.agentAccount', ['agent' => $agent]);
}

// public function updateAgentProfilePic(Request $request)
// {
//     $request->validate([
//         'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//     ]);

//     $agent = Auth::guard('agent')->user();

//     if ($request->hasFile('profile_pic')) {
//         // Delete old profile picture if exists
//         if ($agent->profile_pic) {
//             Storage::disk('public')->delete('profile_pics/' . $agent->profile_pic);
//         }

//         // Store the new picture
//         $fileName = time() . '.' . $request->profile_pic->extension();
//         $request->profile_pic->storeAs('profile_pics', $fileName, 'public');

//         // Update database
//         $agent->profile_pic = $fileName;
//         $agent->save();

//         return redirect()->route('agentAccount')->with('success', 'Profile picture updated successfully!');
//     }

//     return redirect()->route('agentAccount')->with('error', 'Something went wrong!');
// }
public function updateAgentProfilePic(Request $request)
{
    $request->validate([
        'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $agent = Auth::guard('agent')->user();

    if ($request->hasFile('profile_pic')) {
        // Delete old profile picture if exists
        if ($agent->profile_pic) {
            Storage::disk('public')->delete($agent->profile_pic);
        }

        // Store the new picture
        $path = $request->file('profile_pic')->store('profile_pics', 'public');
        
        // Update database with the full path
        $agent->profile_pic = $path;
        $agent->save();

        return redirect()->route('agentAccount')->with('success', 'Profile picture updated successfully!');
    }

    return redirect()->route('agentAccount')->with('error', 'Something went wrong!');
}

    public function agentMaps( Request $request){
        $agent = Auth::guard('agent')->user();

        $query = Property::with('agent')
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
    if ($price = $request->price) {
        // Show properties where price is less than or equal to input
        $query->where('price', '<=', (float) $price);
    
        // Sort by price ascending
        $query->orderByRaw("CASE WHEN price = ? THEN 0 ELSE 1 END", [(float) $price])
              ->orderBy('price', 'asc');
    } else {
        // Default sorting if no price filter
        $query->orderBy('created_at', 'desc');
    }

    // Get all properties that match the filters
    $properties = $query->get();
        return view('agents.agentMaps', compact('properties', 'agent'));
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

    // public function agentMessages()
    // {
    //     $agent = Auth::guard('agent')->user();
    //     $conversations = Message::where('agent_id', $agent->id)
    //         ->with(['property', 'client'])
    //         ->select('property_id', 'client_id')
    //         ->distinct()
    //         ->get()
    //         ->map(function ($message) use ($agent) {
    //             return [
    //                 'property' => $message->property,
    //                 'client' => $message->client,
    //                 'last_message' => Message::where('agent_id', $agent->id)
    //                     ->where('client_id', $message->client_id)
    //                     ->when($message->property_id, function ($query, $property_id) {
    //                         return $query->where('property_id', $property_id);
    //                     }, function ($query) {
    //                         return $query->whereNull('property_id');
    //                     })
    //                     ->latest()
    //                     ->first(),
    //                 'has_unread' => Message::where('agent_id', $agent->id)
    //                     ->where('client_id', $message->client_id)
    //                     ->when($message->property_id, function ($query, $property_id) {
    //                         return $query->where('property_id', $property_id);
    //                     }, function ($query) {
    //                         return $query->whereNull('property_id');
    //                     })
    //                     ->where('sender_type', 'client')
    //                     ->where('is_read', false)
    //                     ->exists(),
    //             ];
    //         })
    //         ->sortByDesc(function ($conversation) {
    //             return $conversation['last_message'] ? $conversation['last_message']->created_at : '2000-01-01';
    //         });

    //     $total_unread = $conversations->filter(function ($conversation) {
    //         return $conversation['has_unread'];
    //     })->count();

    //     return view('agents.agentMessages', compact('agent', 'conversations', 'total_unread'));
    // }

    // public function viewConversation($property_id, $client_id)
    // {
    //     $agent = Auth::guard('agent')->user();
    //     $property = $property_id ? Property::findOrFail($property_id) : null;
    //     $client = Client::findOrFail($client_id);

    //     $updatedCount = Message::where('property_id', $property_id)
    //         ->where('client_id', $client_id)
    //         ->where('agent_id', $agent->id)
    //         ->where('sender_type', 'client')
    //         ->where('is_read', false)
    //         ->update(['is_read' => true]);
    //     \Log::info("Marked $updatedCount messages as read for agent {$agent->id}, property " . ($property_id ?? 'null') . ", client {$client_id}");

    //     $messages = Message::where('client_id', $client_id)
    //         ->where('agent_id', $agent->id)
    //         ->when($property_id, function ($query, $property_id) {
    //             return $query->where('property_id', $property_id);
    //         }, function ($query) {
    //             return $query->whereNull('property_id');
    //         })
    //         ->orderBy('created_at', 'desc')
    //         ->get();

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

    // public function agentMessages()
    // {
    //     $agent = Auth::guard('agent')->user();
    //     $conversations = Message::where('agent_id', $agent->id)
    //         ->with(['property', 'client'])
    //         ->select('property_id', 'client_id')
    //         ->distinct()
    //         ->get()
    //         ->map(function ($message) use ($agent) {
    //             return [
    //                 'property' => $message->property,
    //                 'client' => $message->client,
    //                 'last_message' => Message::where('property_id', $message->property_id)
    //                     ->where('agent_id', $agent->id)
    //                     ->where('client_id', $message->client_id)
    //                     ->latest()
    //                     ->first(),
    //                 'has_unread' => Message::where('property_id', $message->property_id)
    //                     ->where('agent_id', $agent->id)
    //                     ->where('client_id', $message->client_id)
    //                     ->where('sender_type', 'client')
    //                     ->where('is_read', false)
    //                     ->exists(),
    //             ];
    //         })
    //         ->sortByDesc(function ($conversation) {
    //             return $conversation['last_message'] ? $conversation['last_message']->created_at : '2000-01-01';
    //         });

    //     $total_unread = $conversations->filter(function ($conversation) {
    //         return $conversation['has_unread'];
    //     })->count();

    //     return view('agents.agentMessages', compact('agent', 'conversations', 'total_unread'));
    // }

    // public function viewConversation($property_id, $client_id)
    // {
    //     $agent = Auth::guard('agent')->user();
    //     $property = Property::findOrFail($property_id);
    //     $client = Client::findOrFail($client_id);

    //     $updatedCount = Message::where('property_id', $property_id)
    //         ->where('client_id', $client_id)
    //         ->where('agent_id', $agent->id)
    //         ->where('sender_type', 'client')
    //         ->where('is_read', false)
    //         ->update(['is_read' => true]);
    //     \Log::info("Marked $updatedCount messages as read for agent {$agent->id}, property {$property_id}, client {$client_id}");

    //     $messages = Message::where('property_id', $property_id)
    //         ->where('client_id', $client_id)
    //         ->where('agent_id', $agent->id)
    //         ->orderBy('created_at', 'desc')
    //         ->get();

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
    \Log::info("Agent ID: {$agent->id}");

    $conversations = Message::where('agent_id', $agent->id)
        ->with(['property', 'client'])
        ->select('property_id', 'client_id')
        ->distinct()
        ->get()
        ->map(function ($message) use ($agent) {
            $unread_count = Message::where('property_id', $message->property_id)
                ->where('agent_id', $agent->id)
                ->where('client_id', $message->client_id)
                ->where('sender_type', 'client')
                ->where('is_read', false)
                ->count();
            \Log::info("Unread count for agent {$agent->id}, property {$message->property_id}, client {$message->client_id}: {$unread_count}");
            return [
                'property' => $message->property,
                'client' => $message->client,
                'last_message' => Message::where('property_id', $message->property_id)
                    ->where('agent_id', $agent->id)
                    ->where('client_id', $message->client_id)
                    ->latest()
                    ->first(),
                'unread_count' => $unread_count,
            ];
        })
        ->sortByDesc(function ($conversation) {
            return $conversation['last_message'] ? $conversation['last_message']->created_at : '2000-01-01';
        });

    $total_unread = $conversations->sum('unread_count');
    \Log::info("Total unread messages for agent {$agent->id}: {$total_unread}");

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

    // Calculate total_unread for the layout
    $total_unread = Message::where('agent_id', $agent->id)
        ->where('sender_type', 'client')
        ->where('is_read', false)
        ->count();

    return view('agents.agentConversation', compact('agent', 'property', 'client', 'messages', 'total_unread'));
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
        'is_read' => false,
    ]);

    return response()->json(['success' => true, 'message' => 'Message sent successfully']);
}

    // public function agentProperties() {
    //     $agent = Auth::guard('agent')->user();
    //     $properties = Property::where('agent_id', $agent->id)
    //                           ->where('archived', false)
    //                           ->get();
        
    
    //     return view('agents.agentProperties', compact('properties'));
    // }
    public function agentProperties(Request $request)
{
    $agent = Auth::guard('agent')->user();
    $query = Property::query()
        ->with('agent')
        ->where('agent_id', $agent->id)
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
    if ($price = $request->input('price')) {
        // Show properties where price is less than or equal to input
        $query->where('price', '<=', (float) $price);
    
        // Sort by price ascending, prioritizing exact matches
        $query->orderByRaw("CASE WHEN price = ? THEN 0 ELSE 1 END", [(float) $price])
              ->orderBy('price', 'asc');
    } else {
        // Default sorting if no price filter
        $query->orderBy('price', 'asc');
    }

    $properties = $query->paginate(9); // 9 properties per page, matching listings

    return view('agents.agentProperties', compact('properties'));
}
    

    public function createProperty(){
        return view('agents.createProperty');
    }

    // public function storeProperty(Request $request){
    //     $request->validate([
    //         'offer_type' => 'required|in:sell,rent',
    //         'property_type' => 'required|in:condominium,commercial_space,apartment,house,land',
    //         'title' => 'required',
    //         'description' => 'required',
    //         'price' => 'required',
    //         'province' => 'required',
    //         'city' => 'required',
    //         'barangay' => 'required',
    //         'images.*' => 'image', // each image max 2MB
    //     ]);

    //     $agent = Auth::guard('agent')->user();
    //     $imagePaths = [];

    //     if($request->hasFile('images')) {
    //         foreach($request->file('images') as $image) {
    //             $path = $image->store('properties', 'public');
    //             $imagePaths[] = $path;
    //         }
    //     }

    //     Property::create([
    //         'agent_id' => $agent->id,
    //         'offer_type' => $request->offer_type,
    //         'property_type' => $request->property_type,
    //         'title' => $request->title,
    //         'description' => $request->description,
    //         'price' => $request->price,
    //         'province' => $request->province,
    //         'city' => $request->city,
    //         'barangay' => $request->barangay,
    //         'images' => $imagePaths,
    //     ]);

    //     return redirect()->route('agentProperties')->with('success', 'Property added successfully.');
    // }
    public function storeProperty(Request $request)
{
    $request->validate([
        'offer_type' => 'required|in:sell,rent',
        'property_type' => 'required|in:condominium,commercial_space,apartment,house,land',
        'title' => 'required',
        'description' => 'required',
        'price' => 'required|numeric',
        'province' => 'required',
        'city' => 'required',
        'barangay' => 'required',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
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
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'images' => $imagePaths,
    ]);

    return redirect()->route('agentProperties')->with('success', 'Property added successfully.');
}

    public function editProperty($id){
        $property = Property::findOrFail($id);

        return view('agents.editProperty', compact('property'));
    }

    // public function updateProperty(Request $request, $id){
    //     $property = Property::findOrFail($id);

    //     $request->validate([
    //         'offer_type' => 'required|in:sell,rent',
    //         'property_type' => 'required|in:condominium,commercial_space,apartment,house,land',
    //         'title' => 'required',
    //         'description' => 'required',
    //         'price' => 'required|numeric',
    //         'province' => 'required',
    //         'city' => 'required',
    //         'barangay' => 'required',
    //         'images.*' => 'image',
    //     ]);

    //     $imagePaths = $property->images ?? [];

    //     if($request->hasFile('images')) {
    //         foreach($request->file('images') as $image) {
    //             $path = $image->store('properties', 'public');
    //             $imagePaths[] = $path;
    //         }
    //     }

    //     $property->update([
    //         'offer_type' => $request->offer_type,
    //         'property_type' => $request->property_type,
    //         'title' => $request->title,
    //         'description' => $request->description,
    //         'price' => $request->price,
    //         'province' => $request->province,
    //         'city' => $request->city,
    //         'barangay' => $request->barangay,
    //         'images' => $imagePaths,
    //     ]);

    //     $property->save();

    //     return redirect()->route('agentProperties')->with('success', 'Property updated successfully.');
    // }
    public function updateProperty(Request $request, $id)
{
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
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
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
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'images' => $imagePaths,
    ]);

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

    public function viewProperties($id){
    $agent = Auth::guard('agent')->user();
   
    $property = Property::with('agent')->findOrFail($id);
    $similarProperties = Property::with('agent')
        ->where('city', $property->city)
        ->where('id', '!=', $property->id)
        ->where('archived', false)
        ->take(3)
        ->get(); 

   

    return view('agents.viewProperties', compact('property', 'agent', 'similarProperties'));

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

