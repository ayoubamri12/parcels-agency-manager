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
        Schema::create('deliveryman_cities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("delivery_id");
            $table->unsignedBigInteger("city_id");
            $table->unsignedBigInteger('company_id');
            $table->integer("commission");
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('delivery_id')->references('id')->on('deliveries')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveryman_cities');
    }
};
