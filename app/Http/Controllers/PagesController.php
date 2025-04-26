<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function Home(){
        return view('home');
    }

    public function Listings(){
        return view('listings');
    }

    public function Services(){
        return view('services');
    }

    public function About(){
        return view('about');
    }

  
}
