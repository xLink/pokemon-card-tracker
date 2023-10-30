<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deck;

class PagesController extends Controller 
{
    public function dashboard() 
    {
        return inertia('Pages/Dashboard');
    }

} 