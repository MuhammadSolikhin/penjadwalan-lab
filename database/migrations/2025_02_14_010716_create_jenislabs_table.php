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
        Schema::create('jenislabs', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD
            $table->string("name")->unique();
            $table->string("slug")->unique();
            $table->text("description")->nullable();
            $table->timestamps();
=======
            $table->string("nama_jenis_lab")->unique();
            $table->text("deskripsi_jenis_lab")->nullable();
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
        Schema::dropIfExists('jenislabs');
    }
};
