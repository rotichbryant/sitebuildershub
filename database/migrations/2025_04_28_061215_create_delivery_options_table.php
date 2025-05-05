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
        Schema::create('delivery_options', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('business_profile_id');
            $table->foreign('business_profile_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('charged')->nullable()->default(false);
            $table->integer('cost_from')->nullable()->default(0);
            $table->integer('cost_to')->nullable()->default(0);
            $table->string('delivery_to');
            $table->string('delivery_from');
            $table->string('location');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_options');
    }
};
