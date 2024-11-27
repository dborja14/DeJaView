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
        Schema::create('Carts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userId');
            $table->bigInteger('productId');
            $table->bigInteger('size');
            $table->bigInteger('price');
            $table->bigInteger('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
