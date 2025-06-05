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
        Schema::create('pms_files', function (Blueprint $table) {
            $table->id();
            $table->string('pms_id')->nullable();
            $table->string('uploader_id')->nullable();
            $table->dateTime('pms_date')->nullable();
            $table->text('remarks')->nullable();
            $table->string('file_name')->nullable();
            $table->string('orig')->nullable();
            $table->string('folder')->nullable();
            $table->string('year')->nullable();
            $table->string('link')->nullable();
            $table->dateTime('date_uploaded')->nullable();
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
        Schema::dropIfExists('pms_files');
    }
};
