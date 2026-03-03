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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('員工 ID');
            $table->foreignId('site_id')->constrained()->onDelete('cascade')->comment('站點 ID');
            $table->date('date')->comment('班次日期');
            $table->time('scheduled_start')->comment('預計上班時間');
            $table->time('scheduled_end')->comment('預計下班時間');
            $table->enum('status', ['scheduled', 'completed', 'absent', 'exchanged'])->default('scheduled')->comment('班次狀態');
            $table->string('remark')->nullable()->comment('備註');
            $table->timestamps();
            $table->index(['user_id', 'date']);
            $table->index(['site_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
