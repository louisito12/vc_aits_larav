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
        Schema::create('aits_file_models', function (Blueprint $table) {
            $table->id();
            $table->string('table_name')->nullable();
            $table->string('attachment_id')->nullable();
            $table->string('orig_file')->nullable();
            $table->string('file_name')->nullable();
            $table->string('folder_name')->nullable();
            $table->string('year')->nullable();
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
        Schema::dropIfExists('aits_file_models');
    }
};

