<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Message;
use App\Models\Property;
use App\Models\BroadcastProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
Use App\Models\Client;

class ClientsModuleController extends Controller
{
    public function clientsProfile(){
        $client = Auth::guard('client')->user();
        return view('clients.clientsProfile', ['client' => $client]);
    }

    public function updateProfilePic(Request $request)
{
    $request->validate([
        'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $client = Auth::guard('client')->user();

    if ($request->hasFile('profile_pic')) {
        // Delete old profile picture if exists
        if ($client->profile_pic) {
            Storage::disk('public')->delete('profile_pics/' . $client->profile_pic);
        }

        // Store the new picture
        $fileName = time() . '.' . $request->profile_pic->extension();
        $request->profile_pic->storeAs('profile_pics', $fileName, 'public');

        // Update database
        $client->profile_pic = $fileName;
        $client->save();

        return redirect()->route('clientsProfile')->with('success', 'Profile picture updated successfully!');
    }

    return redirect()->route('clientsProfile')->with('error', 'Something went wrong!');
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



        public function clientsFavorites()
    {
        $client = Auth::guard('client')->user();
        
        if (!$client) {
            return redirect()->route('clientLogin')->with('error', 'Please login to view your favorites');
        }
        
        $favorites = $client->favorites()->with('agent')->paginate(6);
        return view('clients.clientsFavorites', compact('favorites'));
    }

    // public function maps(){
    //     $client = Auth::guard('client')->user();
    //     $properties = Property::with('agent')
    //     ->where('archived', false) // Load related agent
    //     ->latest()            // Order by created_at DESC
    //     ->take(3)             // Limit to 3 properties
    //     ->get();
    //     return view('clients.clientsMaps', compact('properties'), ['client' => $client]);
    // }
    public function maps(Request $request){
        $client = Auth::guard('client')->user();
        
        // Start building the query for properties
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
        
        return view('clients.clientsMaps', compact('properties', 'client'));
    }

    // public function messages()
    // {
    //     $client = Auth::guard('client')->user();
    //     \Log::info("Client ID: {$client->id}");

    //     $conversations = Message::where('client_id', $client->id)
    //         ->with(['property', 'agent'])
    //         ->select('property_id', 'agent_id')
    //         ->distinct()
    //         ->get()
    //         ->map(function ($message) use ($client) {
    //             $unread_count = Message::where('client_id', $client->id)
    //                 ->where('agent_id', $message->agent_id)
    //                 ->when($message->property_id, function ($query, $property_id) {
    //                     return $query->where('property_id', $property_id);
    //                 }, function ($query) {
    //                     return $query->whereNull('property_id');
    //                 })
    //                 ->where('sender_type', 'agent')
    //                 ->where('is_read', false)
    //                 ->count();
    //             \Log::info("Unread count for client {$client->id}, property " . ($message->property_id ?? 'null') . ", agent {$message->agent_id}: {$unread_count}");
    //             return [
    //                 'property' => $message->property,
    //                 'agent' => $message->agent,
    //                 'last_message' => Message::where('client_id', $client->id)
    //                     ->where('agent_id', $message->agent_id)
    //                     ->when($message->property_id, function ($query, $property_id) {
    //                         return $query->where('property_id', $property_id);
    //                     }, function ($query) {
    //                         return $query->whereNull('property_id');
    //                     })
    //                     ->latest()
    //                     ->first(),
    //                 'unread_count' => $unread_count,
    //             ];
    //         })
            
    //         ->sortByDesc(function ($conversation) {
    //             return $conversation['last_message'] ? $conversation['last_message']->created_at : '2000-01-01';
    //         });

    //     $total_unread = $conversations->sum('unread_count');
    //     \Log::info("Total unread messages for client {$client->id}: {$total_unread}");

    //     return view('clients.clientsMessages', compact('client', 'conversations', 'total_unread'));
    // }

    // public function viewConversation($property_id, $agent_id)
    // {
    //     $client = Auth::guard('client')->user();
    //     $property = $property_id ? Property::find($property_id) : null; // Use find() instead of findOrFail() to avoid 404
    //     $agent = Agent::findOrFail($agent_id);

    //     $updatedCount = Message::where('client_id', $client->id)
    //         ->where('agent_id', $agent_id)
    //         ->when($property_id, function ($query, $property_id) {
    //             return $query->where('property_id', $property_id);
    //         }, function ($query) {
    //             return $query->whereNull('property_id');
    //         })
    //         ->where('sender_type', 'agent')
    //         ->where('is_read', false)
    //         ->update(['is_read' => true]);
    //     \Log::info("Marked $updatedCount messages as read for client {$client->id}, property " . ($property_id ?? 'null') . ", agent {$agent_id}");

    //     $messages = Message::where('client_id', $client->id)
    //         ->where('agent_id', $agent_id)
    //         ->when($property_id, function ($query, $property_id) {
    //             return $query->where('property_id', $property_id);
    //         }, function ($query) {
    //             return $query->whereNull('property_id');
    //         })
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     // Calculate total_unread for the layout
    //     $total_unread = Message::where('client_id', $client->id)
    //         ->where('sender_type', 'agent')
    //         ->where('is_read', false)
    //         ->count();

    //     return view('clients.clientConversation', compact('client', 'property', 'agent', 'messages', 'total_unread'));
    // }

    // public function sendMessage(Request $request)
    // {
    //     $request->validate([
    //         'property_id' => 'nullable|exists:properties,id',
    //         'agent_id' => 'required|exists:agents,id',
    //         'message' => 'required|string|max:2000',
    //     ]);

    //     $client = Auth::guard('client')->user();
    //     Message::create([
    //         'property_id' => $request->property_id,
    //         'client_id' => $client->id,
    //         'agent_id' => $request->agent_id,
    //         'message' => $request->message,
    //         'sender_id' => $client->id,
    //         'sender_type' => 'client',
    //         'is_read' => false,
    //     ]);

    //     return response()->json(['success' => true, 'message' => 'Message sent successfully']);
    // }

    // public function broadcastMessage(Request $request)
    // {
    //     $request->validate([
    //         'message' => 'required|string|max:2000',
    //     ]);

    //     $client = Auth::guard('client')->user();
    //     $agents = Agent::all(); // Fetch all agents

    //     foreach ($agents as $agent) {
    //         Message::create([
    //             'client_id' => $client->id,
    //             'agent_id' => $agent->id,
    //             'message' => $request->message,
    //             'sender_id' => $client->id,
    //             'sender_type' => 'client',
    //             'is_read' => false,
    //         ]);
    //     }

    //     return response()->json(['success' => true, 'message' => 'Message sent to all agents']);
    // }
    

    // public function messages()
    // {
    //     $client = Auth::guard('client')->user();
    //     \Log::info("Client ID: {$client->id}");

    //     $conversations = Message::where('client_id', $client->id)
    //         ->with(['property', 'agent'])
    //         ->select('property_id', 'agent_id')
    //         ->distinct()
    //         ->get()
    //         ->map(function ($message) use ($client) {
    //             $unread_count = Message::where('property_id', $message->property_id)
    //                 ->where('client_id', $client->id)
    //                 ->where('agent_id', $message->agent_id)
    //                 ->where('sender_type', 'agent')
    //                 ->where('is_read', false)
    //                 ->count();
    //             \Log::info("Unread count for client {$client->id}, property {$message->property_id}, agent {$message->agent_id}: {$unread_count}");
    //             return [
    //                 'property' => $message->property,
    //                 'agent' => $message->agent,
    //                 'last_message' => Message::where('property_id', $message->property_id)
    //                     ->where('client_id', $client->id)
    //                     ->where('agent_id', $message->agent_id)
    //                     ->latest()
    //                     ->first(),
    //                 'unread_count' => $unread_count,
    //             ];
    //         })
    //         ->sortByDesc(function ($conversation) {
    //             return $conversation['last_message'] ? $conversation['last_message']->created_at : '2000-01-01';
    //         });

    //     $total_unread = $conversations->sum('unread_count');
    //     \Log::info("Total unread messages for client {$client->id}: {$total_unread}");

    //     return view('clients.clientsMessages', compact('client', 'conversations', 'total_unread'));
    // }
//     public function messages()
// {
//     $client = Auth::guard('client')->user();
//     \Log::info("Client ID: {$client->id}");

//     $conversations = Message::where('client_id', $client->id)
//         ->with(['property', 'agent'])
//         ->select('property_id', 'agent_id')
//         ->distinct()
//         ->get()
//         ->map(function ($message) use ($client) {
//             $unread_count = Message::where('property_id', $message->property_id)
//                 ->where('client_id', $client->id)
//                 ->where('agent_id', $message->agent_id)
//                 ->where('sender_type', 'agent')
//                 ->where('is_read', false)
//                 ->count();
//             \Log::info("Unread count for client {$client->id}, property {$message->property_id}, agent {$message->agent_id}: {$unread_count}");
            
//             // For placeholder properties (ID = 0), we need to handle them specially
//             $property = $message->property;
//             if ($message->property_id == 0) {
//                 // Create a placeholder property object with minimal information
//                 $property = new \stdClass();
//                 $property->id = 0;
//                 $property->title = "General Inquiry";
//                 $property->images = [];
//             }
            
//             return [
//                 'property' => $property,
//                 'agent' => $message->agent,
//                 'last_message' => Message::where('property_id', $message->property_id)
//                     ->where('client_id', $client->id)
//                     ->where('agent_id', $message->agent_id)
//                     ->latest()
//                     ->first(),
//                 'unread_count' => $unread_count,
//             ];
//         })
//         ->sortByDesc(function ($conversation) {
//             return $conversation['last_message'] ? $conversation['last_message']->created_at : '2000-01-01';
//         });

//     $total_unread = $conversations->sum('unread_count');
//     \Log::info("Total unread messages for client {$client->id}: {$total_unread}");

//     return view('clients.clientsMessages', compact('client', 'conversations', 'total_unread'));
// }
public function messages()
{
    $client = Auth::guard('client')->user();
    \Log::info("Client ID: {$client->id}");
    $conversations = Message::where('client_id', $client->id)
        ->with(['property', 'agent'])
        ->select('property_id', 'agent_id')
        ->distinct()
        ->get()
        ->map(function ($message) use ($client) {
            $unread_count = Message::where('client_id', $client->id)
                ->where('agent_id', $message->agent_id)
                ->where(function($query) use ($message) {
                    // Match the property_id condition exactly (including NULL)
                    if (is_null($message->property_id)) {
                        $query->whereNull('property_id');
                    } else {
                        $query->where('property_id', $message->property_id);
                    }
                })
                ->where('sender_type', 'agent')
                ->where('is_read', false)
                ->count();
            \Log::info("Unread count for client {$client->id}, property " . ($message->property_id ?? 'NULL') . ", agent {$message->agent_id}: {$unread_count}");
            
            // For general inquiries (property_id is NULL), create a placeholder property object
            $property = $message->property;
            if (is_null($message->property_id)) {
                // Create a placeholder property object with minimal information
                $property = new \stdClass();
                $property->id = null;
                $property->title = "General Inquiry";
                $property->images = [];
            }
            
            return [
                'property' => $property,
                'agent' => $message->agent,
                'last_message' => Message::where('client_id', $client->id)
                    ->where('agent_id', $message->agent_id)
                    ->where(function($query) use ($message) {
                        // Match the property_id condition exactly (including NULL)
                        if (is_null($message->property_id)) {
                            $query->whereNull('property_id');
                        } else {
                            $query->where('property_id', $message->property_id);
                        }
                    })
                    ->latest()
                    ->first(),
                'unread_count' => $unread_count,
            ];
        })
        ->sortByDesc(function ($conversation) {
            return $conversation['last_message'] ? $conversation['last_message']->created_at : '2000-01-01';
        });
    $total_unread = $conversations->sum('unread_count');
    \Log::info("Total unread messages for client {$client->id}: {$total_unread}");
    return view('clients.clientsMessages', compact('client', 'conversations', 'total_unread'));
}

//     public function viewConversation($property_id, $agent_id)
// {
//     $client = Auth::guard('client')->user();
//     $property = Property::findOrFail($property_id);
//     $agent = Agent::findOrFail($agent_id);

//     $updatedCount = Message::where('property_id', $property_id)
//         ->where('client_id', $client->id)
//         ->where('agent_id', $agent_id)
//         ->where('sender_type', 'agent')
//         ->where('is_read', false)
//         ->update(['is_read' => true]);
//     \Log::info("Marked $updatedCount messages as read for client {$client->id}, property {$property_id}, agent {$agent_id}");

//     $messages = Message::where('property_id', $property_id)
//         ->where('client_id', $client->id)
//         ->where('agent_id', $agent_id)
//         ->orderBy('created_at', 'desc')
//         ->get();

//     // Calculate total_unread for the layout
//     $total_unread = Message::where('client_id', $client->id)
//         ->where('sender_type', 'agent')
//         ->where('is_read', false)
//         ->count();

//     return view('clients.clientConversation', compact('client', 'property', 'agent', 'messages', 'total_unread'));
// }
// public function viewConversation($property_id, $agent_id)
// {
//     $client = Auth::guard('client')->user();
    
//     // Handle placeholder property (ID = 0)
//     if ($property_id == 0) {
//         $property = new \stdClass();
//         $property->id = 0;
//         $property->title = "General Inquiry";
//         $property->images = [];
//     } else {
//         $property = Property::findOrFail($property_id);
//     }
    
//     $agent = Agent::findOrFail($agent_id);

//     $updatedCount = Message::where('property_id', $property_id)
//         ->where('client_id', $client->id)
//         ->where('agent_id', $agent_id)
//         ->where('sender_type', 'agent')
//         ->where('is_read', false)
//         ->update(['is_read' => true]);
//     \Log::info("Marked $updatedCount messages as read for client {$client->id}, property {$property_id}, agent {$agent_id}");

//     $messages = Message::where('property_id', $property_id)
//         ->where('client_id', $client->id)
//         ->where('agent_id', $agent_id)
//         ->orderBy('created_at', 'desc')
//         ->get();

//     // Calculate total_unread for the layout
//     $total_unread = Message::where('client_id', $client->id)
//         ->where('sender_type', 'agent')
//         ->where('is_read', false)
//         ->count();

//     return view('clients.clientConversation', compact('client', 'property', 'agent', 'messages', 'total_unread'));
// }
public function viewConversation($agent_id, $property_id = null)
{
    $client = Auth::guard('client')->user();
    // Handle general inquiries (property_id is null)
    if (is_null($property_id)) {
        $property = new \stdClass();
        $property->id = null;
        $property->title = "General Inquiry";
        $property->images = [];
        $property_id_condition = null;
    } else {
        $property = Property::findOrFail($property_id);
        $property_id_condition = $property_id;
    }
    
    $agent = Agent::findOrFail($agent_id);
    
    // Mark messages as read
    $query = Message::where('client_id', $client->id)
        ->where('agent_id', $agent_id)
        ->where('sender_type', 'agent')
        ->where('is_read', false);
    
    if (is_null($property_id_condition)) {
        $query->whereNull('property_id');
    } else {
        $query->where('property_id', $property_id_condition);
    }
    
    $updatedCount = $query->update(['is_read' => true]);
    \Log::info("Marked $updatedCount messages as read for client {$client->id}, property " . ($property_id_condition ?? 'NULL') . ", agent {$agent_id}");
    
    // Get messages
    $query = Message::where('client_id', $client->id)
        ->where('agent_id', $agent_id);
    
    if (is_null($property_id_condition)) {
        $query->whereNull('property_id');
    } else {
        $query->where('property_id', $property_id_condition);
    }
    
    $messages = $query->orderBy('created_at', 'desc')->get();
    
    // Calculate total_unread for the layout
    $total_unread = Message::where('client_id', $client->id)
        ->where('sender_type', 'agent')
        ->where('is_read', false)
        ->count();
    
    return view('clients.clientConversation', compact('client', 'property', 'agent', 'messages', 'total_unread'));
}
    // public function sendMessage(Request $request)
    // {
    //     $request->validate([
    //         'property_id' => 'required|exists:properties,id',
    //         'agent_id' => 'required|exists:agents,id',
    //         'message' => 'required|string|max:2000',
    //     ]);

    //     $client = Auth::guard('client')->user();
    //     Message::create([
    //         'property_id' => $request->property_id,
    //         'client_id' => $client->id,
    //         'agent_id' => $request->agent_id,
    //         'message' => $request->message,
    //         'sender_id' => $client->id,
    //         'sender_type' => 'client',
    //         'is_read' => false,
    //     ]);

    //     return response()->json(['success' => true, 'message' => 'Message sent successfully']);
    // }
//     public function sendMessage(Request $request)
// {
//     $request->validate([
//         'property_id' => 'required|integer',
//         'agent_id' => 'required|exists:agents,id',
//         'message' => 'required|string|max:2000',
//     ]);
    
//     $client = Auth::guard('client')->user();
    
//     $message = Message::create([
//         'property_id' => $request->property_id,
//         'client_id' => $client->id,
//         'agent_id' => $request->agent_id,
//         'message' => $request->message,
//         'sender_id' => $client->id,
//         'sender_type' => 'client',
//         'is_read' => false,
//     ]);
    
//     if($request->expectsJson()) {
//         return response()->json(['success' => true, 'message' => 'Message sent successfully']);
//     }
    
//     return redirect()->back()->with('success', 'Message sent successfully');
// }
public function sendMessage(Request $request)
{
    $request->validate([
        'property_id' => 'nullable', // Allow null values
        'agent_id' => 'required|exists:agents,id',
        'message' => 'required|string|max:2000',
    ]);
    
    $client = Auth::guard('client')->user();
    
    // Handle 'null' string from form input
    $property_id = ($request->property_id === 'null') ? null : $request->property_id;
    
    $message = Message::create([
        'property_id' => $property_id,
        'client_id' => $client->id,
        'agent_id' => $request->agent_id,
        'message' => $request->message,
        'sender_id' => $client->id,
        'sender_type' => 'client',
        'is_read' => false,
    ]);
    
    if($request->expectsJson()) {
        return response()->json(['success' => true, 'message' => 'Message sent successfully']);
    }
    
    return redirect()->back()->with('success', 'Message sent successfully');
}


//     public function contactAgent(Request $request)
// {
//     $request->validate([
//         'agent_id' => 'required|exists:agents,id',
//         'message' => 'required|string|max:2000',
//     ]);

//     $client = Auth::guard('client')->user();
    
//     // Create a placeholder property ID (0) for direct agent communication
//     // This allows us to use the existing conversation system
//     $placeholderId = 0;
    
//     Message::create([
//         'property_id' => $placeholderId,
//         'client_id' => $client->id,
//         'agent_id' => $request->agent_id,
//         'message' => $request->message,
//         'sender_id' => $client->id,
//         'sender_type' => 'client',
//         'is_read' => false,
//     ]);

//     return redirect()->route('messages')->with('success', 'Your message has been sent to the agent.');
// }
public function contactAgent(Request $request)
{
    $request->validate([
        'agent_id' => 'required|exists:agents,id',
        'message' => 'required|string|max:2000',
    ]);
    
    $client = Auth::guard('client')->user();
    
    // Use NULL for general inquiries instead of property_id = 0
    Message::create([
        'property_id' => null,
        'client_id' => $client->id,
        'agent_id' => $request->agent_id,
        'message' => $request->message,
        'sender_id' => $client->id,
        'sender_type' => 'client',
        'is_read' => false,
    ]);
    
    return redirect()->route('messages')->with('success', 'Your message has been sent to the agent.');
}


    public function myProperty(){
        $client = Auth::guard('client')->user();
        return view('clients.clientsMyProperty', ['client' => $client]);
    }


    // public function clientsViewProperties($id)
    // {
    //     $client = Auth::guard('client')->user();
    //     $property = Property::with('agent')->findOrFail($id);
    //     $similarProperties = Property::where('city', $property->city)
    //         ->where('id', '!=', $property->id)
    //         ->take(3)
    //         ->get(); 
            
    //         $query = Property::query()
    //         ->with('agent')
    //         ->where('archived', false);// Example for similar properties
    //     return view('clients.clientViewProperties', compact('property', 'client', 'similarProperties'));
    // }
    public function clientsViewProperties($id)
{
    $client = Auth::guard('client')->user();
    $property = Property::with('agent')->findOrFail($id);

    $similarProperties = Property::with('agent')
        ->where('city', $property->city)
        ->where('id', '!=', $property->id)
        ->where('archived', false)
        ->take(3)
        ->get(); 

    return view('clients.clientViewProperties', compact('property', 'client', 'similarProperties'));
}



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
