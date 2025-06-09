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
        Schema::create('aits_notifs', function (Blueprint $table) {
            $table->id();
            $table->string('aits_table')->nullable();
            $table->string('aits_id')->nullable();
            $table->string('aits_process')->nullable();
            $table->string('send_to_user_id')->nullable();
            $table->string('notif')->default(0)->nullable();
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
        Schema::dropIfExists('aits_notifs');
    }
};
