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
        Schema::create('aits_deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('is_transact')->nullable();
            $table->string('request_no')->nullable();
            $table->string('delivery_type_id')->nullable();
            $table->string('name_receiver')->nullable();
            $table->string('company_name')->nullable();
            $table->string('contact_receiver')->nullable();
            $table->string('count_documents')->nullable();
            $table->string('area_id')->nullable();
            $table->string('complete_address')->nullable();
            $table->longText('receiver_note')->nullable();
            $table->longText('delivery_remarks')->nullable();
            $table->string('assign_by')->nullable();
            $table->string('date_assign')->nullable();
            $table->string('messenger_id')->nullable();
            $table->string('request_status')->nullable();
            $table->dateTime('delivery_date')->nullable();
            $table->string('status')->default(1)->nullable();
            $table->dateTime('date_created')->nullable();
            $table->string('orig_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aits_deliveries');
    }
};
