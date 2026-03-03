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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('員工姓名');
            $table->string('employee_id')->unique()->nullable()->comment('員工工號');
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable()->comment('聯絡電話');
            $table->string('line_user_id')->unique()->nullable()->comment('LINE 唯一識別碼');
            $table->string('role')->default('security')->comment('角色: security, manager, accountant, admin');
            $table->integer('base_salary')->default(0)->comment('月薪/底薪');
            $table->integer('hourly_rate')->default(0)->comment('時薪(加班/機動用)');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_active')->default(true)->comment('是否在職');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
