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
        Schema::create('preferences', function (Blueprint $table) {
            $table->id();
            $table->string('q1');
            $table->string('q2');
            $table->string('q3');
            $table->string('q4');
            $table->string('q5');
            $table->integer('q6');
            $table->timestamps();

            $table->unsignedBigInteger('q2')->change();
            $table->unsignedBigInteger('q3')->change();
            $table->unsignedBigInteger('q5')->change();
    
            $table->foreign('q2')->references('id')->on('shoetypes')->onDelete('cascade');
            $table->foreign('q3')->references('id')->on('fits')->onDelete('cascade');
            $table->foreign('q5')->references('id')->on('brands')->onDelete('cascade');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferences');
    }
};
