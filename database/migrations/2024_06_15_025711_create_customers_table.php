<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
       // Schema::dropIfExists('customers');
     //  php artisan migrate   :fresh

    // php artisan tinker
 //2. Schema::drop('your_table_name')
 //3. php artisan migrate

     // php artisan db:seed 
    // DB::statement('ALTER TABLE customers CHANGE company_name description bigint(20) ');
 //   php artisan migrate:refresh --path=/database/migrations/fileName.php
    //php artisan migrate:refresh  --path=/database/migrations/2024_06_15_025711_create_customers_table.php
    //Schema::dropIfExists('customers');
    if(Schema::hasTable('customers')) return;

        Schema::create('customers', function (Blueprint $table) {
           
            $table->id('customer_id'); 
            $table->string('customer_name')->unique();

            $table->unsignedBigInteger('customertype_id'); //onwer,auditor etc
           
            $table->unsignedBigInteger('product_id');//tally silver,gold
         
            $table->enum('amc', ['yes', 'no'])->default('yes');
            $table->enum('tss_status', ['active', 'inactive'])->default('active');
            $table->string('tss_adminemail'); 
            $table->date('tss_expirydate');
          
            $table->enum('profile_status', ['Followup', 'Others'])->default('Followup');
            
            $table->unsignedBigInteger('staff_id');
            $table->string('remarks');
          //  tss,tss_active,tss_admin,tss_expirydate 
           // (Followup),FollowupExecutive,remarks,
           
            $table->string('tally_no')->nullable();
            $table->string('tally_version')->nullable();
           
            $table->boolean('whatsapp_telegram_group')->default(false);
             
            $table->timestamps();

            // Foreign key constraint to contacts table
         //   $table->foreign('primary_contact_id')->references('contact_id')->on('contacts')->onDelete('cascade');


          



        });

       
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
