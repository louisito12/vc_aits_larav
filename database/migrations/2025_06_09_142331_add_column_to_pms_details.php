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
        Schema::table('pms_details', function (Blueprint $table) {
            $table->string('pms_notif')->nullable();
            $table->text('send_to')->nullable();
            $table->text('cc_to')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pms_details', function (Blueprint $table) {
            //
        });
    }
};
