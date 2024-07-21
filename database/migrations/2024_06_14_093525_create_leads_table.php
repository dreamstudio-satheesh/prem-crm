<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('leads', function (Blueprint $table) {
      $table->id();
      $table->dateTime('date');
      $table->string('customer_name');
      $table->string('product');
      $table->decimal('amount', 8, 2)->nullable();
      $table->string('contact_no');
      $table->string('status');
      $table->text('remarks')->nullable();
      $table->dateTime('follow_up_date')->nullable();
      $table->timestamps();
    });


  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('leads');
  }
};
