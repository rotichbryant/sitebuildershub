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
        Schema::table('user_subscription', function (Blueprint $table) {
            $table->boolean('active')->nullable()->default(false)->after('id');
            $table->enum('billing_cycle',['infinity','monthly','yearly'])->nullable()->default('infinity')->after('active');
            $table->string('end_date')->nullable()->default(null)->after('billing_cycle');
            $table->string('start_date')->nullable()->default(null)->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_subscription', function (Blueprint $table) {
            $table->dropColumn('active');
            $table->dropColumn('end_date');
            $table->dropColumn('start_date');
        });
    }
};
