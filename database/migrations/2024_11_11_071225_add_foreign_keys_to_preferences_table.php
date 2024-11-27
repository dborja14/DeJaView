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
            $table->unsignedBigInteger('q2');  // Correct type for foreign key
            $table->unsignedBigInteger('q3');
            $table->string('q4');
            $table->unsignedBigInteger('q5');  // Correct type for foreign key
            $table->integer('q6');
            $table->timestamps();
        
            $table->foreign('q2')->references('id')->on('shoetype')->onDelete('cascade');
            $table->foreign('q3')->references('id')->on('fits')->onDelete('cascade');
            $table->foreign('q5')->references('id')->on('brands')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('preferences', function (Blueprint $table) {
            //
        });
    }
};
