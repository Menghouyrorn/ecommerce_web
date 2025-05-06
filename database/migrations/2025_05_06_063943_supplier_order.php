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
        Schema::create('supplier_order', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('supplier_id');
            $table->integer('exchange_rate');
            $table->integer('symbol');
            $table->integer('total_quantity');
            $table->integer('total_amount');
            $table->longText('order_data');
            $table->longText('remarks');
            $table->text('created_by');
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
