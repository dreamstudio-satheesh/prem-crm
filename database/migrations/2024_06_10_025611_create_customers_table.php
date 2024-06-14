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
            $table->string('mobile_number');
            $table->string('email_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('tally_no')->nullable();
            $table->string('tally_version')->nullable();
<<<<<<< HEAD
          //  $table->json('contact_info')->nullable();
=======
>>>>>>> bcc8f649c0bc8c72793fee1f0c1e13cdcd23f6f3
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->boolean('whatsapp_telegram_group')->default(false); 
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
