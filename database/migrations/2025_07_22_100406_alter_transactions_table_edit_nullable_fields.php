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
            $table->uuid('sourceable_id')->nullable()->default(null)->change();
            $table->uuid('targetable_id')->nullable()->default(null)->change();
            $table->string('confirmation_code')->nullable()->default(null)->change();
            $table->string('payment_method')->nullable()->default(null)->change();
            $table->string('status')->nullable()->default(null)->change();
            $table->integer('status_code')->nullable()->default(null)->change();
            $table->string('reference')->nullable()->default(null)->change();
            $table->string('currency')->nullable()->default('KES')->after('confirmation_code');
            $table->date('paid_at')->nullable()->default(null)->after('currency');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {       
            $table->string('sourceable_id')->nullable()->default(null)->change();
            $table->string('targetable_id')->nullable()->default(null)->change();
            $table->string('confirmation_code')->change();
            $table->string('payment_method')->change();
            $table->string('status')->change();
            $table->integer('status_code')->change();
            $table->string('reference')->change();
            $table->dropColumn('currency');        
            $table->dropColumn('paid_at');             
        });
    }
};
