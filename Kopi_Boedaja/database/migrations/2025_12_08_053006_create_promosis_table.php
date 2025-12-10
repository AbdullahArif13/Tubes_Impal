<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promosis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_promosi');
            $table->text('deskripsi');
            $table->date('tanggal_berlaku');
            $table->date('tanggal_berakhir');
             $table->enum('tipe', ['percent', 'fixed', 'b1g1'])->default('percent');

            // Untuk 'percent': simpan angka persen (misal 10)
            // Untuk 'fixed': simpan nominal (misal 10000)
            // Untuk 'b1g1': kamu bisa gunakan buy_x/get_y
            $table->unsignedInteger('nilai')->default(0);

            // Maks potongan (hanya dipakai bila ada cap untuk tipe percent)
            $table->unsignedInteger('maks_potongan')->nullable();

            // Untuk B1G1
            $table->unsignedSmallInteger('buy_x')->nullable();
            $table->unsignedSmallInteger('get_y')->nullable();

            // Minimal pembelian (opsional)
            $table->unsignedInteger('min_total')->nullable();

            // Limit penggunaan (misal per-user atau total)
            $table->unsignedInteger('limit_total')->nullable();
            $table->unsignedInteger('used_count')->default(0);

            // Status aktif
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promosis');
    }
};
