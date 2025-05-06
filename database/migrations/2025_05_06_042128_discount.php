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
        Schema::create('discount', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('coupon');
            $table->string('discount_type');
            $table->integer('uses');
            $table->integer('max_uses');
            $table->integer('max_use_per_user');
            $table->longText('data')->nullable();
            $table->integer('discount_rate');
            $table->timestamp('start_data')->nullable();
            $table->timestamp('end_data')->nullable();
            $table->string('status');
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
