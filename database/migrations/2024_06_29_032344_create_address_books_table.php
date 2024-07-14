<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_books', function (Blueprint $table) {
            $table->bigIncrements('address_id'); // Changed from idd to address_id
            $table->unsignedBigInteger('customer_id'); // Changed from id to customer_id
            $table->integer('index')->nullable(); // Changed from indx to index
            $table->integer('customer_code')->nullable();
            $table->unsignedInteger('customer_type_id')->nullable(); // Changed from addresstype to address_type_id
            $table->string('contact_person', 150)->nullable();
            $table->string('phone_no', 250)->nullable(); // Changed from phoneno to phone_no
            $table->string('email', 250)->nullable();
            $table->string('address', 250)->nullable(); 
            $table->string('pin_code', 20)->nullable(); 
            $table->string('state', 150)->nullable(); 
            $table->string('country', 150)->nullable(); 
            $table->timestamps();


            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address_books');
    }
}
