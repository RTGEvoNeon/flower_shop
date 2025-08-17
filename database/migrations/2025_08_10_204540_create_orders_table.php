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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_phone', 20);
            $table->string('customer_email');
            $table->string('delivery_address', 500);
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', [
                'pending',
                'confirmed',
                'in_progress',
                'delivered',
                'cancelled'
            ])->default('pending');
            $table->datetime('delivery_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
