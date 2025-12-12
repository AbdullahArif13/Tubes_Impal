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
        'deskripsi',
        'harga',
        'gambar_produk',
        'kategori',
        'tersedia'
    ];
    
    protected $casts = [
        'tersedia' => 'boolean',
    ];

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}
