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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('員工 ID');
            $table->foreignId('shift_id')->nullable()->constrained()->onDelete('set null')->comment('對應班次');
            $table->enum('type', ['in', 'out'])->comment('打卡類型: 進場/退場');
            $table->timestamp('check_time')->comment('打卡時間');
            $table->decimal('latitude', 10, 8)->comment('打卡經度');
            $table->decimal('longitude', 11, 8)->comment('打卡緯度');
            $table->integer('distance')->nullable()->comment('距離站點中心點的公尺數');
            $table->boolean('is_abnormal')->default(false)->comment('是否異常 (地點/時間)');
            $table->string('photo_path')->nullable()->comment('打卡照片路徑');
            $table->string('remark')->nullable()->comment('異常原因備註');
            $table->timestamps();
            $table->index(['user_id', 'check_time']);
            $table->index(['shift_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
