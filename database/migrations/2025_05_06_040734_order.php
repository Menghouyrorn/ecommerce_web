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
        Schema::create('order', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('order_no')->unique();
            $table->string('user_name');
            $table->integer('total_amount');
            $table->integer('total_items');
            $table->longText('data');
            $table->string('paid_by');
            $table->string('status');
            $table->text('remarks');
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
