<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aits_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('page')->nullable();
            $table->string('user_id')->nullable();
            $table->string('table_name')->nullable();
            $table->string('description')->nullable();
            $table->string('is_messenger')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('date_created')->nullable();






            $table->timestamps();

            //             -id
            // -page
            // -process_id 
            // -user_id
            // -table_name
            // -description
            // -is_messenger
            // -status
            // -date_created
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aits_audit_logs');
    }
};
