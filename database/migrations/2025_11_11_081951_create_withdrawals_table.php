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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('user_id');
            $table->string('user_guard')->nullable();

            $table->string('transaction_id')->nullable();

            $table->decimal('amount', 15, 2)->default(0);
            $table->decimal('balance_amount', 15, 2)->default(0);

            $table->string('status')->default('0');

            $table->decimal('charge', 15, 2)->default(0);
            $table->decimal('admin_charge', 15, 2)->default(0);

            $table->json('bank_details')->nullable();

            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
