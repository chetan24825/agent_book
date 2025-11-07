<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('category_id');

            $table->string('product_name');
            $table->string('product_slug')->unique();

            $table->string('thumbphotos')->nullable();
            $table->string('multiple_image')->nullable();

            $table->text('short_description')->nullable();
            $table->longText('terms_conditions')->nullable();

            $table->decimal('mrp_price', 10, 2)->default(0);
            $table->decimal('purchase_cost', 10, 2)->default(0);
            $table->decimal('purchase_gst', 10, 2)->default(0);
            $table->decimal('net_cost', 10, 2)->default(0);

            $table->decimal('sale_price', 10, 2)->default(0);
            $table->decimal('sale_gst', 10, 2)->default(0);
            $table->decimal('payable_gst', 10, 2)->default(0);

            $table->boolean('status')->default(1);
            $table->boolean('in_stock')->default(1);

            $table->text('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
