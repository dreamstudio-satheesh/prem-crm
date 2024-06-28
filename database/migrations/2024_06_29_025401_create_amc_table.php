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
        Schema::create('amc', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->date('amc_from_date')->nullable();
            $table->date('amc_to_date')->nullable();
            $table->date('amc_renewal_date')->nullable();
            $table->integer('no_of_visits')->nullable();
            $table->decimal('amc_amount', 8, 2)->nullable();
            $table->decimal('amc_last_year_amount', 8, 2)->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amc');
    }
};
