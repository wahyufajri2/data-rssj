<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlankPageController extends Controller
{
    public function index()
    {
        return view('pages.blank', [
            'title' => 'Halaman Kosong',
        ]);
    }
}
