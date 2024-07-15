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
        Schema::create('service_call_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_call_id');
            $table->timestamp('call_start_time')->nullable();
            $table->timestamp('call_end_time')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        
            $table->foreign('service_call_id')->references('id')->on('service_calls')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_call_logs');
    }
};
