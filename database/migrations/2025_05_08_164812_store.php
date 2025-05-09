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
        Schema::create('store', function (Blueprint $table) {
           $table->id()->autoIncrement();
           $table->string('store_no');
           $table->string('store_name');
           $table->string('store_address');
           $table->string('store_phone');
           $table->string('store_email');
           $table->string('store_telegram');
           $table->integer('manager_id');
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
