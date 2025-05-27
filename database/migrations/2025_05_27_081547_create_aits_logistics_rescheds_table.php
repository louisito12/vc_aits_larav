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
        Schema::create('aits_logistics_rescheds', function (Blueprint $table) {
            $table->id();
            $table->string('logistic_id')->nullable();
            $table->string('user_id')->nullable();
            $table->date('date_resched')->nullable();
            $table->string('remarks')->nullable();
            $table->string('is_messenger')->nullable();
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
        Schema::dropIfExists('aits_logistics_rescheds');
    }
};
