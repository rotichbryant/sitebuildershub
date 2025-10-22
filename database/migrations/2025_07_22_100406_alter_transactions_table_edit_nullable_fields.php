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
            $table->datetime('paid_at')->nullable()->default(null)->after('currency');     
            $table->uuid('user_id')->nullable()->default(null);
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');           
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
            $table->dropColumnIfExists('currency');        
            $table->dropColumnIfExists('paid_at');             
            $table->dropForeign('user_id');
            $table->dropColumnIfExists ('user_id');            
        });
    }
};
