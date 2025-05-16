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
        Schema::create('aits_room_models', function (Blueprint $table) {
            $table->id();
            $table->string('room_name')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('date_created')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aits_room_models');
    }
};
