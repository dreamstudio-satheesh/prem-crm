<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id('contact_id');
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email')->nullable();
<<<<<<< HEAD
         //   $table->json('contact_info')->nullable();
=======
            $table->string('address')->nullable();
            $table->string('company')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); //  users table
>>>>>>> bcc8f649c0bc8c72793fee1f0c1e13cdcd23f6f3
            $table->timestamps();
            
            // Foreign key constraint  users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
