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
        Schema::create('localt_parcels', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->double('price');
            $table->string('status');
            $table->string('state');
            $table->string('city');
            $table->timestamp('delivery_date')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('delivery_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('delivery_id')->references('id')->on('deliveries')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('localt_parcels');
    }
};
