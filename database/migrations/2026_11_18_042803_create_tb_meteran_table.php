<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_meteran', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('id_lokasi')->constrained('tb_lokasi')->cascadeOnDelete();
            $table->string('nama_meteran');
            $table->decimal('maks_watt', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_meteran');
    }
};
