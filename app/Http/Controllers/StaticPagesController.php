<?php

namespace App\Http\Controllers;

use App\Models\Joke; 
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaticPagesController extends Controller
{
    public function welcome(): View 
    {
        $randomJoke = Joke::inRandomOrder()->first();
       return view('static.welcome', compact('randomJoke'));
    }
    public function about(): View
    {
        return view('static.about');
    }

    /**
     * Contact us page 
     */
    public function contactUs(): View // Method  name
    {
        return view('static.contact-us');
    }

    /**
     * Pricing page 
     */
    public function pricing(): View
    {
        return view('static.pricing');
    }

     /**
     * Privacy page 
     */
    public function privacy(): View
    {
        return view('static.privacy');
    }
}
