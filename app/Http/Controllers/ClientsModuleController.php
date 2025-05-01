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

    public function clientsListings(){
        $client = Auth::guard('client')->user();
        return view('clients.clientsListings', ['client' => $client]);
    }

    public function favorites(){
        $client = Auth::guard('client')->user();
        return view('clients.clientsFavorites', ['client' => $client]);
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

}
