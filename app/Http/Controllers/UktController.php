<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class UktController extends Controller
{
    public function index()
    {
        return redirect()->route('usulan','ukt');
    }
}
