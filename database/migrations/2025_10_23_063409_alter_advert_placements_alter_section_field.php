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
        Schema::table('advert_placements', function (Blueprint $table) {
            $table->enum('section',array('advert','footer','leader-banner','login','top-banner','signup'))->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advert_placements', function (Blueprint $table) {
            $table->enum('section',array('advert','leader-banner','top-banner'))->change();
        });
    }
};
