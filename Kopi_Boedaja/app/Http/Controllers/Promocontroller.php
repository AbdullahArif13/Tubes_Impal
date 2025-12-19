<?php

namespace App\Http\Controllers;

use App\Models\Promosi;
use Illuminate\Support\Facades\Auth;

class PromoController extends Controller
{
    public function index()
    {
        // hanya user login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $promos = Promosi::where('aktif', true)
            ->whereDate('tanggal_berlaku', '<=', now())
            ->whereDate('tanggal_berakhir', '>=', now())
            ->get();

        return view('promo.index', compact('promos'));
    }
}
