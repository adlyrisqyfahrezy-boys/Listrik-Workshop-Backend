<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_ruang', function (Blueprint $table): void {
            $table->id();
            $table->string('nama_ruang');
            $table->foreignId('id_lokasi')->constrained('tb_lokasi')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_ruang');
    }
};
