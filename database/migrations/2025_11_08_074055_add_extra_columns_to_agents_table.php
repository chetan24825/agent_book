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
        Schema::table('agents', function (Blueprint $table) {
            // Bank Details
            $table->string('account_name')->nullable()->after('agent_code');
            $table->string('account_type')->nullable()->after('account_name');
            $table->string('account_number')->nullable()->after('account_type');
            $table->string('bank_name')->nullable()->after('account_number');
            $table->string('ifsc_code')->nullable()->after('bank_name');
            $table->string('check_image')->nullable()->after('ifsc_code');
            $table->string('pancard')->nullable()->after('check_image');

            $table->string('admin_verification_status')->default(0);


            // Aadhar Document Fields (ordered correctly)
            $table->string('aadhar_card')->nullable()->after('pancard');
            $table->string('aadhar_card_front')->nullable()->after('aadhar_card');
            $table->string('aadhar_card_back')->nullable()->after('aadhar_card_front');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->dropColumn([
                'admin_verification_status',
                'account_name',
                'account_type',
                'account_number',
                'bank_name',
                'ifsc_code',
                'check_image',
                'pancard',
                'aadhar_card',
                'aadhar_card_front',
                'aadhar_card_back'
            ]);
        });
    }
};
