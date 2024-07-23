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
      $table->unsignedBigInteger('customer_id'); 
      $table->unsignedBigInteger('product_id');
      $table->decimal('amount', 8, 2)->nullable();
      $table->string('contact_no');
      $table->string('status');
      $table->text('remarks')->nullable();
      $table->dateTime('follow_up_date')->nullable();
      $table->string('referral_name')->nullable(); // Name of the referrer
      $table->string('referral_contact_no')->nullable(); // Contact number of the referrer
      $table->decimal('referral_reward', 8, 2)->nullable(); // Reward or incentive for the referral
      
      $table->timestamps();
  
      $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
      $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
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
