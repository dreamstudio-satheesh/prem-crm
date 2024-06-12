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
            $table->json('contact_info')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->enum('designation', ['Owner', 'Accounts Manager', 'Accountant', 'Auditor', 'TAX Consultant'])->nullable();
            $table->string('type_of_call')->default('Free Call'); // Default value
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->enum('tss_status', ['Active', 'Not Active'])->default('Active'); // Default value
            $table->date('tss_expiry')->nullable();
            $table->boolean('auto_cloud_backup_tdl_module')->default(false); // Default value
            $table->boolean('whatsapp_telegram_group')->default(false); // Default value
            $table->timestamp('call_start_time')->nullable();
            $table->timestamp('call_end_time')->nullable();
            $table->decimal('total_hours_spent', 8, 2)->nullable(); // Assuming hours will be stored as decimal
            $table->enum('status_of_the_call', ['Pending', 'Completed', 'Cancelled'])->default('Pending'); // Default value
            $table->decimal('service_charges', 8, 2)->nullable();
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
