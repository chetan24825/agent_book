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
        Schema::table('commission_installments', function (Blueprint $table) {
            $table->string('utr_id')->nullable();
            $table->string('payment_by')->default('agent');
            $table->string('payment_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commission_installments', function (Blueprint $table) {
            $table->dropColumn(['utr_id', 'payment_image', 'payment_by']);
        });
    }
};
