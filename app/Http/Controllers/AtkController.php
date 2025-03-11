<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AtkController extends Controller
{
    public function index()
    {
        return redirect()->route('usulan','atk');
    }
}
