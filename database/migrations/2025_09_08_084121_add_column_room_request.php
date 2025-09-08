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
            $table->string('requested_text')->nullable();
            $table->string('req_text')->nullable();
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
