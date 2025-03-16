<?php

namespace App\Http\Controllers;

use App\Models\Playstation;
use Illuminate\Http\Request;

class LayoutsController extends Controller
{
    public function index()
    {
        $playstations = Playstation::paginate(10);
        return view('home',compact('playstations'));
    }
}
