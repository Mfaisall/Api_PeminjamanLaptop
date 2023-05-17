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
        Schema::create('peminjaman_laptops', function (Blueprint $table) {
            $table->id();
            $table->integer('no_laptop');
            $table->string('nama');
            $table->string('nis');
            $table->string('rombel');
            $table->string('rayon');
            $table->date('tanggal_peminjaman');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_laptops');
    }
};
