<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PunchIn;
use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Auth;

// 公開路由
Route::get('/login', Login::class)->name('login');
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// 需登入後的路由
Route::middleware(['auth'])->group(function () {
    
    Route::get('/', function () {
        $user = Auth::user();
        if ($user->role === 'admin' || $user->role === 'manager') {
            return redirect()->route('manager.monitor');
        } elseif ($user->role === 'accountant') {
            return redirect()->route('accountant.payroll');
        }
        return redirect()->route('punch-in');
    });

    // 保全功能
    Route::middleware(['role:security'])->group(function () {
        Route::get('/punch-in', PunchIn::class)->name('punch-in');
        Route::get('/leave', \App\Livewire\LeaveRequestList::class)->name('leave.index');
    });

    // 主管管理介面
    Route::middleware(['role:manager'])->group(function () {
        Route::prefix('manager')->group(function () {
            Route::get('/monitor', \App\Livewire\AttendanceMonitor::class)->name('manager.monitor');
            Route::get('/leaves', \App\Livewire\LeaveApproval::class)->name('manager.leaves');
            Route::get('/scheduling', \App\Livewire\ManagerScheduling::class)->name('manager.scheduling');
        });
    });

    // 會計管理介面
    Route::middleware(['role:accountant'])->group(function () {
        Route::prefix('accountant')->group(function () {
            Route::get('/payroll', \App\Livewire\PayrollSummary::class)->name('accountant.payroll');
        });
    });
});
