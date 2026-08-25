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
        Schema::table('posting_categories', function (Blueprint $table) {
            $table->uuid('child_sub_category_id')->nullable()->default(null)->after('sub_category_id');
            $table->foreign('child_sub_category_id')->references('id')->on('child_sub_categories')->onUpdate('cascade')->onDelete('cascade');       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posting_categories', function (Blueprint $table) {
            $table->dropForeign('postings_categories_sub_category_id_foreign');
            $table->dropColumn('child_sub_category_id');
        });
    }
};
