<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('free_days_req_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('free_day_req_id')->constrained('free_days_requests');
            $table->foreignId('file_id')->constrained('files');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('free_days_req_files');
    }
};
