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
            $table->string('conducted_by')->nullable();
            $table->string('noted_by')->nullable();
            $table->string('pms_status')->default('Pending')->nullable();
            $table->string('approved_by')->nullable();
            $table->dateTime('approve_date')->nullable();





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
