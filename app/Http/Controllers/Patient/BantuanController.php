<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;

class BantuanController extends Controller
{
    public function index()
    {
        return view('pages.patient.bantuan');
    }
}
