<?php

namespace App\Http\Controllers\Rakuten;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AAAController extends Controller
{
    public function add()
    {
      return view('rakuten.aaa.create');
    }
}
