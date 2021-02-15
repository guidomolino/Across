<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
  public function store(Request $request) {
    $data = $request -> all();
    $stanza = Stanza::create($data);
    return redirect() -> route('stanze');
  }
}
