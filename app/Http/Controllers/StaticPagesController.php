<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class StaticPagesController extends Controller
{
    public function welcome(): View 
    {
       
       return view('static.welcome');
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
}
