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
        Schema::create('security_deposits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->string('guard')->nullable();
            $table->decimal('amount', 10, 2)->default(0);

            $table->boolean('is_refundable')->default(0); // 1 = refundable, 0 = not
            $table->dateTime('is_refundable_date')->nullable();

            $table->boolean('is_refundable_request')->default(0); // 1 = refundable, 0 = not
            $table->dateTime('is_refundable_request_date')->nullable();

            $table->string('utr_id')->nullable();
            $table->string('payment_image')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('status')->default(0); // 0 = pending, 1 = approved, 2 = rejected ,3 = completed
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_deposits');
    }
};
