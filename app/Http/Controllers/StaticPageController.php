<?php

namespace App\Http\Controllers;

class StaticPageController extends Controller
{
    public function kontak()    { return view('static.kontak'); }
    public function bantuan()   { return view('static.bantuan'); }
    public function kebijakan() { return view('static.kebijakan'); }
}
