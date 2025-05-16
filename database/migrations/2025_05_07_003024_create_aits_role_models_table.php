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
        Schema::create('aits_role_access', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('role_id')->nullable();
            $table->string('status')->default(1)->nullable();
            $table->dateTime('date_created')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aits_role_models');
    }
};
