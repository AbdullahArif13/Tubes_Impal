<?php

namespace App\Http\Controllers;

use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::where('tersedia', 1)->get();
        return view('menu', compact('menus'));
    }
}
