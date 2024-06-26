<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('customer_id');
            $table->unsignedInteger('primary_address_id')->nullable();
            $table->unsignedBigInteger('default_address_type_id');
            $table->string('customer_name', 191)->unique();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->enum('amc', ['yes', 'no'])->default('yes');
            $table->enum('tss_status', ['active', 'inactive'])->default('active');
            $table->string('tss_adminemail', 191)->nullable();
            $table->date('tss_expirydate')->nullable();
            $table->enum('profile_status', ['Followup', 'Others'])->nullable();
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->string('remarks', 191)->nullable();
            $table->string('tally_no', 191)->nullable();
            $table->string('tally_version', 191)->nullable();
            $table->boolean('whatsapp_telegram_group')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
