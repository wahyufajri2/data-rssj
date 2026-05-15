<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index()
    {
        return view('pages.portal', [
            'title' => 'PRIMA - Portal Resmi Informasi Mahasiswa & Alumni',
        ]);
    }
}
