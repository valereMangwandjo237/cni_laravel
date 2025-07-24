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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('immat_id');
            $table->string('type'); // 'recto', 'verso', 'profile', etc.
            $table->string('path'); // ex: storage/cni/recto.jpg
            $table->timestamps();

            $table->foreign('immat_id')->references('id')->on('immatriculations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
