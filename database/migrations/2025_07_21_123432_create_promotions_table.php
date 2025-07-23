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
        Schema::create('promotions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('id')->primary();
            $table->boolean('active')->nullable()->default(false);
            $table->float('amount',8,2);
            $table->date('date_from');
            $table->date('date_to');
            $table->uuid('placement_id');
            $table->foreign('placement_id')->references('id')->on('advert_placements')->onUpdate('cascade')->onDelete('cascade');  
            $table->uuid('posting_id');
            $table->foreign('posting_id')->references('id')->on('postings')->onUpdate('cascade')->onDelete('cascade');  
            $table->uuid('transaction_id')->nullable();
            $table->foreign('transaction_id')->nullable()->references('id')->on('transactions')->onUpdate('cascade')->onDelete('set null');                          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
