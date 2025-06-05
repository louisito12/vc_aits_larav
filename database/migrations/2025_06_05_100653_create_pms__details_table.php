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
        Schema::create('pms_details', function (Blueprint $table) {
            $table->id();
            $table->string('pms_name')->nullable();
            $table->text('pms_description')->nullable();
            $table->string('status')->default(1)->nullable();
            $table->dateTime('date_start')->nullable();
            $table->string('user_id')->nullable();
            $table->dateTime('date_created')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pms__details');
    }
};
