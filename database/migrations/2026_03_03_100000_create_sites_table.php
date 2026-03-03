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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('站點名稱 (崗位)');
            $table->string('address')->nullable()->comment('地址');
            $table->decimal('latitude', 10, 8)->comment('經度');
            $table->decimal('longitude', 11, 8)->comment('緯度');
            $table->integer('radius')->default(100)->comment('地理圍欄半徑 (公尺)');
            $table->time('daily_start_time')->default('08:00:00')->comment('標準上班時間');
            $table->time('daily_end_time')->default('20:00:00')->comment('標準下班時間');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
