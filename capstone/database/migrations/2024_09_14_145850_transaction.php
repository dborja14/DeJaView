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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userId');
            $table->bigInteger('productId');
            $table->bigInteger('quantity');
            $table->bigInteger('totalPrice');
            $table->string('address');
            $table->string('paymentMethod');
            $table->string('paymentStatus');
            $table->string('deliveryMethod');
            $table->string('deliveryStatus');
            $table->string('paymentImage');
            $table->string('orderStatus');
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
