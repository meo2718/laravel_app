<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        //$this->viewData['shops'] = Shop::where('owner_id', Auth::id())->get();
        // resources/views/user/index
        return view('user.index');
    }
}
