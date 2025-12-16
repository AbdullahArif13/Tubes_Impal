<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promosi;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promosi::where('aktif', true)->get();

        return view('promo.index', compact('promos'));
    }
}