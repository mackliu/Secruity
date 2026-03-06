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
     * 匯出 Excel
     */
    public function exportExcel()
    {
        $fileName = "Payroll_{$this->year}_{$this->month}.xlsx";
        
        return Excel::download(
            new \App\Exports\PayrollExport($this->payrollData, $this->year, $this->month), 
            $fileName
        );
    }

    public function render()
    {
        return view('livewire.payroll-summary');
    }
}
