<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_perangkat', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('id_ruang')->constrained('tb_ruang')->cascadeOnDelete();
            $table->string('nama_perangkat');
            $table->integer('jumlah');
            $table->string('uom');
            $table->decimal('daya', 10, 2);
            $table->decimal('total_daya', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_perangkat');
    }
};
