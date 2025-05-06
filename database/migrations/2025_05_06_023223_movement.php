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
        Schema::create('movement', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('movement_no');
            $table->integer('order_id');
            $table->string('movement_type')->nullable();
            $table->integer('source_location_id')->nullable();
            $table->integer('target_location_id')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->string('status');
            $table->longText('items');
            $table->integer('total_item');
            $table->string('remarks')->nullable();
            $table->string('created_by')->nullable();
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
