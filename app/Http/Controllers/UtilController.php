<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilController extends Controller
{
    //
    public function credits()
    {
        return view('utils.credits');
    }

    public function manuales()
    {
        return view('utils.manuales');
    }
}
