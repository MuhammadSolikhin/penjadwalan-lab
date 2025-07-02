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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('spesifikasi');
            $table->text('deskripsi')->nullable();
            $table->enum('status',['digunakan','rusak','tidak dipakai'])->default('tidak dipakai');

            $table->foreignId('kategori_barang_id')->constrained('kategori_barangs');
            $table->foreignId('lab_id')->constrained('laboratorium_unpams');

            $table->unsignedBigInteger('meja_id')->nullable();
            $table->foreign('meja_id')->references('id')->on('barangs');

            $table->timestamps();
            
            // Indexes
            $table->index(['nama'], 'barangs_nama_index');
            $table->index(['status'], 'barangs_status_index');
            $table->index(['kategori_barang_id'], 'barangs_kategori_barang_id_index');
            $table->index(['lab_id'], 'barangs_lab_id_index');
            $table->index(['meja_id'], 'barangs_meja_id_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
