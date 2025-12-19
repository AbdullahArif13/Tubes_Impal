<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanans';

    protected $fillable = [
        'pelanggan_id',
        'total_harga',
        'status',
        'catatan'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    public function details()
    {
        return $this->hasMany(Detail_Pesanan::class);
    }

    // helper untuk menghitung total dari detail_pesanans
    public function calculateTotal(): int
    {
        return $this->detailPesanans()->get()->sum(function ($d) {
            return ($d->harga ?? 0) * ($d->jumlah ?? 0);
        });
    }

    // panggil saat menyimpan/checkout
    public function recalcAndSaveTotal()
    {
        $this->total_harga = $this->calculateTotal();
        $this->save();
    }
}
