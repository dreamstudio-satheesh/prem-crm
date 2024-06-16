<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id('position_id');
            $table->string('position_name');
            $table->timestamps();
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->id('contact_id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('company')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('position_id')->references('position_id')->on('positions')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('contact_phones', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('contact_id');
            $table->string('phone_number');
            $table->enum('phone_type', ['mobile', 'phone']);
            $table->timestamps();

            // Foreign key constraint to contacts table
            $table->foreign('contact_id')->references('contact_id')->on('contacts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('contact_phones');
        Schema::dropIfExists('positions');
    }
}
