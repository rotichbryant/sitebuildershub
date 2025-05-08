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
        Schema::create('business_stores', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('coords');
            $table->uuid('business_profile_id');
            $table->foreign('business_profile_id')->references('id')->on('business_profiles')->onDelete('cascade');
            $table->json('open_from');
            $table->json('open_to');
            $table->string('location');
            $table->string('name');
            $table->longText('tips');
            $table->json('working_days');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_stores');
    }
};
