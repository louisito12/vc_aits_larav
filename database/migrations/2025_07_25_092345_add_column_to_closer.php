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
        Schema::table('aits_request_closers', function (Blueprint $table) {
            $table->string('initial_notif')->nullable()->default(0);
            $table->string('opening_notif')->nullable()->default(0);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aits_request_closers', function (Blueprint $table) {
            //
        });
    }
};
