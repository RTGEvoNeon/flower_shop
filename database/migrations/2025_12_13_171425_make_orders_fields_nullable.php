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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_email')->nullable()->change();
            $table->string('delivery_address', 500)->nullable()->change();
            $table->datetime('delivery_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_email')->nullable(false)->change();
            $table->string('delivery_address', 500)->nullable(false)->change();
            $table->datetime('delivery_date')->nullable(false)->change();
        });
    }
};
