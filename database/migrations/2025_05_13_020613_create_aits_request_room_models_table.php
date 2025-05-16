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
        Schema::create('aits_request_room_models', function (Blueprint $table) {
            $table->id();
            $table->string('is_transact')->nullable();
            $table->string('room_id')->nullable();
            $table->string('event_id')->nullable();
            $table->string('remarks')->nullable();
            $table->dateTime('date_from')->nullable();
            $table->dateTime('date_to')->nullable();
            $table->string('request_by')->nullable();
            $table->string('edited_by')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('date_created')->nullable();
            $table->string('request_status')->nullable();
            $table->string('approve_by')->nullable();
            $table->dateTime('approve_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aits_request_room_models');
    }
};
