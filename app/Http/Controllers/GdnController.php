<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class GdnController extends Controller
{
    public function index()
    {
        return redirect()->route('usulan','gdn');
    }
}
