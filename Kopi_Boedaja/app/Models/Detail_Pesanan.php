<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_Pesanan extends Model
{
    use HasFactory;

    // karena nama tabelmu 'detail__pesanans' (double underscore)
    protected $table = 'detail_pesanans';

    protected $fillable = [
        'pesanan_id',
        'menu_id',
        'jumlah',
        'subtotal',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function getSubtotalAttribute($value)
    {
        // jika kamu menyimpan subtotal di kolom: return $value;
        // kalau tidak menyimpan, hitung berdasarkan harga*jumlah
        if ($value) {
            return (int) $value;
        }

        return (int) (($this->harga ?? 0) * ($this->jumlah ?? 0));
    }
}
