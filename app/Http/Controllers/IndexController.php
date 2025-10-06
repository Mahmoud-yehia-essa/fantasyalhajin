<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{

      public function showSoon()
    {

        return view('frontend.soon');
    }
}
