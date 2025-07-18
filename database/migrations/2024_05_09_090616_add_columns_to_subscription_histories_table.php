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
        Schema::table('subscription_histories', function (Blueprint $table) {
            $table->string('subscription_type')->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_histories', function (Blueprint $table) {
            $table->dropColumn('subscription_type');
            $table->dropColumn('total_amount');
        });
    }
};
