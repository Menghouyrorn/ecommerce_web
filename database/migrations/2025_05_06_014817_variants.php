<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('product_id');
            $table->integer('currency_id');
            $table->integer('price');
            $table->string('sku');
            $table->string('barcode');
            $table->integer('stock_quantity');
            $table->integer('reorder_quantity');
            $table->integer('stock_status');
            $table->timestamps();
        });

        Schema::create('variant_values', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('variant_id');
            $table->integer('attribute_value_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
