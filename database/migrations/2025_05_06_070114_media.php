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
        Schema::create('media', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->string('filename');
            $table->string('size');
            $table->string('mime_type');
            $table->string('path');
            $table->timestamps();
        });

        Schema::create('media_attach', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('media_id');
            $table->string('attach_type');
            $table->integer('attach_id');
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
