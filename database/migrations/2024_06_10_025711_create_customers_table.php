<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id('customer_id');
            $table->string('customer_name');
            $table->unsignedBigInteger('primary_contact_id');
            $table->string('email_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('tally_no')->nullable();
            $table->string('tally_version')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->boolean('whatsapp_telegram_group')->default(false);
            $table->timestamps();

            // Foreign key constraint to contacts table
            $table->foreign('primary_contact_id')->references('contact_id')->on('contacts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
