<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Sponsor & Guard
            $table->unsignedBigInteger('sponsor_id')->nullable()->after('id');
            $table->string('guard')->nullable()->after('sponsor_id');

            // Status
            $table->tinyInteger('status')->default(0)->after('guard');
            $table->tinyInteger('admin_verification_status')->default(0)->after('status');

            // Contact + Address
            $table->string('phone')->nullable()->after('status');
            $table->string('phone_2')->nullable()->after('phone');
            $table->string('avatar')->nullable()->after('phone_2');
            $table->string('address')->nullable()->after('avatar');
            $table->string('state')->nullable()->after('address');
            $table->string('city')->nullable()->after('state');

            // Bank Details
            $table->string('account_name')->nullable()->after('city');
            $table->string('account_type')->nullable()->after('account_name');
            $table->string('account_number')->nullable()->after('account_type');
            $table->string('bank_name')->nullable()->after('account_number');
            $table->string('ifsc_code')->nullable()->after('bank_name');
            $table->string('check_image')->nullable()->after('ifsc_code');
            $table->string('pancard')->nullable()->after('check_image');

            // Aadhar
            $table->string('aadhar_card')->nullable()->after('pancard');
            $table->string('aadhar_card_front')->nullable()->after('aadhar_card');
            $table->string('aadhar_card_back')->nullable()->after('aadhar_card_front');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'sponsor_id',
                'guard',
                'status',
                'admin_verification_status',
                'phone_2',
                'phone',
                'avatar',
                'address',
                'state',
                'city',
                'account_name',
                'account_type',
                'account_number',
                'bank_name',
                'ifsc_code',
                'check_image',
                'pancard',
                'aadhar_card',
                'aadhar_card_front',
                'aadhar_card_back',
            ]);
        });
    }
};
