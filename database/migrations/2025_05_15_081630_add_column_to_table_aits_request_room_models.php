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
        Schema::table('aits_request_room_models', function (Blueprint $table) {
            $table->string('year')->nullable();
            $table->string('request_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aits_request_room_models', function (Blueprint $table) {
            //
        });
    }
};
