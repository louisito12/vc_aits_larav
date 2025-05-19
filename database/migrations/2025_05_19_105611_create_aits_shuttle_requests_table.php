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
        Schema::create('aits_shuttle_requests', function (Blueprint $table) {
            $table->id();
            $table->string('is_transact')->nullable();
            $table->dateTime('departure_date')->nullable();
            $table->dateTime('appointment_date')->nullable();
            $table->dateTime('pick_up_date')->nullable();
            $table->string('client_name')->nullable();
            $table->string('manager_id')->nullable();
            $table->string('passenger_number')->nullable();
            $table->string('type')->nullable();
            $table->string('purpose')->nullable();
            $table->string('car_id')->nullable();
            $table->string('driver_id')->nullable();
            $table->string('estimated_time')->nullable();
            $table->string('destination')->nullable();
            $table->string('remarks')->nullable();
            $table->string('user_id')->nullable();
            $table->dateTime('date_created')->nullable();
            $table->string('request_status')->nullable();
            $table->string('approved_by')->nullable();
            $table->dateTime('date_approved')->nullable();
            $table->string('orig_id')->nullable();
            $table->string('edited_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aits_shuttle_requests');
    }
};
