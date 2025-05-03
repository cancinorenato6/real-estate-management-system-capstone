<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Agent;
use App\Models\Message;
class AdminModuleController extends Controller
{
    public function adminDashboard(){
        $admin = Auth::guard('admin')->user();
        return view('admin.adminDashboard', ['admin' => $admin]);
    }

    public function adminAgents(){
        $admin = Auth::guard('admin')->user();
        $agents = Agent::all();
        return view('admin.adminAgents', ['admin' => $admin, 'agents' => $agents]);
    } 

    public function agentsRegister(Request $request)
    {
        $validated = $request->validate([
            'prc_id' => 'required|string|max:55|unique:agents,prc_id',
            'name' => 'required|string|max:55',
            'age' => 'required|integer|min:18|max:99',
            'birthday' => 'required|date',
            'contactno' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email',
            'username' => 'required|string|min:4|max:55|unique:agents,username',
            'password' => 'required|string|min:8|confirmed',
            'profile_pic' => 'nullable',
            // 'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        
        if ($request->hasFile('profile_pic')) {
    $profilePath = $request->file('profile_pic')->store('profile_pictures', 'public');
} else {
    $profilePath = null;
}

        $agent = Agent::create([
            'prc_id' => $validated['prc_id'],
            'name' => $validated['name'],
            'age' => $validated['age'],
            'birthday' => $validated['birthday'],
            'contactno' => $validated['contactno'],
            'address' => $validated['address'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => bcrypt($validated['password']),
            // 'profile_pic' => $validated['profile_pic'],
            'profile_pic' => $profilePath,
        ]);

        // Auth::guard('agent')->login($agent);

        return redirect()->route('adminAgents')->with('success', 'Agent registered and logged in!');
    }


    public function agentsCreate(){
        $admin = Auth::guard('admin')->user();
        return view('admin.agentsCreate', ['admin' => $admin]);
    }

    public function deactivateAgent($id)
{
    $agent = Agent::findOrFail($id);
    $agent->status = $agent->status == 1 ? 0 : 1; // Set status to Inactive
    $agent->save();

    return redirect()->back()->with('success', 'Agent deactivated successfully!');
}

public function viewAgent($id)
{
    $admin = Auth::guard('admin')->user(); // still get admin data if needed
    $agent = Agent::findOrFail($id); // get the agent data

    return view('admin.agentView', compact('agent', 'admin'));
}

}
