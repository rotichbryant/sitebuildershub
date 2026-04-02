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
         Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['sourceable_id', 'sourceable_type','targetable_id','targetable_type']);
            $table->string('payment_url')->after('payment_method');
            $table->uuid('invoice_id')->nullable()->default(null)->after('confirmation_code');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onUpdate('cascade')->onDelete('set null');           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['invoice_id']);
            $table->dropColumn(['invoice_id']);
            $table->morphs('sourceable');
            $table->morphs('targetable');            
        });
    }
};
