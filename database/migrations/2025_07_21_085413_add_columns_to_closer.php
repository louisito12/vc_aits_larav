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
            $table->dateTime('date_from')->nullable();
            $table->string('notif')->default(0)->nullable();

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
