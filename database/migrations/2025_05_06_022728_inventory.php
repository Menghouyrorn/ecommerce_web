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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('inventory_no');
            $table->integer('variant_id');
            $table->integer('store_id');
            $table->integer('stock_quantity');
            $table->string('reorder_quantity');
            $table->string('stock_status');
            $table->string('remarks')->nullable();
            $table->string('created_by');
            $table->timestamp('last_restocked_at')->useCurrent();
            $table->string('last_restocked_by');
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
