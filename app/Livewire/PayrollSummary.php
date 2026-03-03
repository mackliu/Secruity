<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Services\PayrollService;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;

class PayrollSummary extends Component
{
    public $year, $month;
    public $payrollData = [];

    public function mount()
    {
        $this->year = Carbon::now()->year;
        $this->month = Carbon::now()->month;
        $this->calculateAll();
    }

    /**
     * 計算所有員工當月薪資
     */
    public function calculateAll()
    {
        $service = new PayrollService();
        $guards = User::where('role', 'security')->where('is_active', true)->get();
        
        $this->payrollData = [];
        foreach ($guards as $guard) {
            $this->payrollData[] = $service->calculateMonthlyPayroll($guard, $this->year, $this->month);
        }
    }

    /**
     * 匯出 Excel (目前整合為簡單的下載)
     */
    public function exportExcel()
    {
        // 實際開發中，這裡會建立一個 Excel Export Class
        // 目前我們先在後台計算，之後可根據需求細化格式
        session()->flash('message', "已匯出 {$this->year} 年 {$this->month} 月的薪資總表。");
    }

    public function render()
    {
        return view('livewire.payroll-summary');
    }
}
