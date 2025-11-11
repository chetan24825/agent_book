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
            $table->unsignedBigInteger('user_id')->nullable(); // Who placed the order
            $table->string('guard')->nullable(); // If multi auth: agent / user / admin etc
            $table->string('custom_order_id')->nullable(); // If multi auth: agent / user / admin etc


            $table->decimal('total_amount', 50, 2)->default(0);
            $table->decimal('tax', 50, 2)->default(0);

            $table->string('payment_status')->default('pending');

            $table->string('order_status')->default('pending');
            // pending | confirmed | shipped | delivered | cancelled

            $table->string('order_by')->nullable();


            $table->unsignedBigInteger('commission_user_id')->nullable(); // Who placed the order
            $table->string('commission_guard')->nullable();
            $table->decimal('total_commission', 50, 2)->default(0);
            $table->string('commission_status')->default(0);
            $table->date('commission_date')->nullable();

            $table->softDeletes();

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
