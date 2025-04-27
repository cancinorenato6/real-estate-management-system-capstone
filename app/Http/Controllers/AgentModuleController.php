<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AgentModuleController extends Controller
{
    public function agentDashboard(){
        $agent = Auth::guard('agent')->user();
        return view('agent.agentDashboard', ['agent' => $agent]);
    }
}

