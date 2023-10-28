<?php

namespace App\Http\Controllers;

class SetController extends Controller 
{
    public function showAll() 
    {
        return view('pages.sets');
    }

    public function showSingle(Request $request, Set $set)
    {

    }

}