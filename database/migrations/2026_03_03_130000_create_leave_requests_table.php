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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('申請人 ID');
            $table->string('type')->comment('假別: sick, personal, annual, special');
            $table->dateTime('start_time')->comment('開始時間');
            $table->dateTime('end_time')->comment('結束時間');
            $table->text('reason')->nullable()->comment('事由');
            $table->string('attachment_path')->nullable()->comment('證明文件路徑');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->comment('審核狀態');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->comment('審核人');
            $table->text('reject_reason')->nullable()->comment('駁回原因');
            $table->timestamps();
            $table->index(['user_id', 'status']);
            $table->index(['start_time', 'end_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
