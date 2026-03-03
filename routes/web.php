<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PunchIn;

Route::get('/', function () {
    return view('welcome');
});

// 保全功能
Route::get('/punch-in', PunchIn::class)->name('punch-in');
Route::get('/leave', \App\Livewire\LeaveRequestList::class)->name('leave.index');

// 主管管理介面
Route::prefix('manager')->group(function () {
    Route::get('/monitor', \App\Livewire\AttendanceMonitor::class)->name('manager.monitor');
    Route::get('/leaves', \App\Livewire\LeaveApproval::class)->name('manager.leaves');
    Route::get('/scheduling', \App\Livewire\ManagerScheduling::class)->name('manager.scheduling');
});

// 會計管理介面
Route::prefix('accountant')->group(function () {
    Route::get('/payroll', \App\Livewire\PayrollSummary::class)->name('accountant.payroll');
});
