<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laboratorium_unpams', function (Blueprint $table) {
            $table->id();
            $table->string('kode_laboratorium')->unique();
            $table->string('nama_laboratorium');
            $table->integer('kapasitas_laboratorium');
            $table->boolean('status_laboratorium')->default(1); // 1 = tersedia, 0 = tidak tersedia

            $table->foreignId('lokasi_id')->constrained('lokasis');
            $table->foreignId('jenislab_id')->constrained('jenislabs');

            $table->text('deskripsi_laboratorium')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laboratorium_unpams');
    }
};
