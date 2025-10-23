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
        Schema::table('postings', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('negotiate');
            $table->dropColumn('quantity');
            $table->string('quotation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('postings', function (Blueprint $table) {
            $table->integer('price');
            $table->string('negotiate');;
            $table->integer('quantity');
            $table->dropColumn('quotation');
        });
    }
};
