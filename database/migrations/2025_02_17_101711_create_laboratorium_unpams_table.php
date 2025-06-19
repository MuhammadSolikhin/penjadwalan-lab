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
        Schema::create('laboratorium_unpams', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('kapasitas');
            $table->enum('status', ['tersedia', 'tidak tersedia'])->default('tersedia');

            $table->unsignedBigInteger('lokasi_id');
            $table->foreign('lokasi_id')
            ->references('id')
            ->on('lokasis');

            $table->unsignedBigInteger('jenislab_id');
            $table->foreign('jenislab_id')
              ->references('id')
              ->on('jenislabs');

              $table->timestamps();
=======
            $table->string('nama_laboratorium');
            $table->integer('kapasitas_laboratorium');
            $table->enum('status_laboratorium', ['tersedia', 'tidak tersedia'])->default('tersedia');

            $table->foreignId('lokasi_id')->constrained('lokasis');
            $table->foreignId('jenislab_id')->constrained('jenislabs');

            $table->text('deskripsi_laboratorium')->nullable();

            $table->timestamps();

            $table->softDeletes();
>>>>>>> 4107aac2a9b972583670c9a86514222ee0cb2599
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
