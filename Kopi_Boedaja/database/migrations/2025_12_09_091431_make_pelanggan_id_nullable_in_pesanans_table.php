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
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropForeign(['pelanggan_id']);
            $table->unsignedBigInteger('pelanggan_id')->nullable()->change();
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
   public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropForeign(['pelanggan_id']);
            $table->unsignedBigInteger('pelanggan_id')->change();
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->cascadeOnDelete();
        });
    }


};
