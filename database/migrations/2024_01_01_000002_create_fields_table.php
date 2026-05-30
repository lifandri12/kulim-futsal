<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->id('id_field');
            $table->string('nama_lapangan');
            $table->string('lokasi');
            $table->decimal('harga_per_jam', 10, 2);
            $table->enum('status', ['tersedia', 'tidak tersedia'])->default('tersedia');
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
