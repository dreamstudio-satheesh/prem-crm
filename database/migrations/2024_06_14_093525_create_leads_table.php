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
            $table->id('leads_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('designation'); // Corrected typo from 'desgination'
            $table->dateTime('followup_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->enum('followup_type', ['CALL', 'DEMO', 'EMAIL', 'MEETING', 'TASK'])->nullable();
            $table->enum('status', ['NEW', 'ASSIGNED', 'IN PROCESS', 'CONVERTED', 'DEAD'])->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->text('comments')->nullable();
            $table->enum('product_category', ['SALES', 'AMC', 'SERVICE', 'TDL', 'OTHERS'])->nullable();
            $table->enum('lead_source', ['WEBSITE', 'PARTNER', 'WALK IN', 'REFERENCE', 'JUST DIAL'])->nullable();
            $table->enum('industry', ['OTHERS'])->nullable();
            $table->enum('hierarchy', ['OTHERS'])->nullable();
            $table->unsignedBigInteger('industry_id')->default(0); // Changed to unsignedBigInteger
            $table->timestamps();
        });

        // No additional changes needed in the second schema table modification section
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
