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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD
            $table->string("name")->unique();
            $table->tinyInteger("priority")->default(1);
            $table->timestamps();
=======
            $table->string("nama_peran")->unique();
            $table->tinyInteger("prioritas_peran")->default(1);
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
        Schema::dropIfExists('roles');
    }
};
