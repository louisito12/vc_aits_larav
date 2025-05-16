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
        Schema::create('aits_vehicle_models', function (Blueprint $table) {
            $table->id();
            $table->string('is_transact')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('plate_number')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('date_created')->nullable();
            $table->dateTime('orig_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aits_vehicle_models');
    }
};
