<?php

namespace App\Http\Controllers;

class PokedexController extends Controller
{
    public function index()
    {
        return inertia('Pages/Pokedex/Index');
    }
}
