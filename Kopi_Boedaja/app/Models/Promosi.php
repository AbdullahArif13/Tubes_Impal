<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promosi extends Model
{
    use HasFactory;

    protected $table = 'promosis';

    protected $fillable = [
        'nama_promosi',
        'deskripsi',
        'tanggal_berlaku',
        'tanggal_berakhir',
        'tipe',
        'nilai',
        'maks_potongan',
        'buy_x',
        'get_y',
        'min_total',
        'limit_total',
        'used_count',
        'aktif',
    ];
}