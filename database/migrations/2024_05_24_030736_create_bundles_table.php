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
        Schema::create('bundles', function (Blueprint $table) {
            $table->id();
            $table->string('bundle_no')->unique();
            $table->string('lay_no')->nullable();
            $table->string('lot_no')->nullable();
            $table->string('po_no')->nullable();
            $table->string('style_no')->nullable();
            $table->string('size')->nullable();
            $table->integer('qty')->nullable();
            $table->string('barcode_from');
            $table->string('barcode_to');
            $table->string('current_section')->default('cutting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bundles');
    }
};
