<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $fillable = [
        'nama',
        'harga',
        'gambar_produk',
        'deskripsi',
        'kategori',
        'tersedia'
    ];

    protected $casts = [
        'tersedia' => 'boolean',
    ];
}
