<?php

namespace App\Services;

use App\Models\User;
use App\Models\Shift;
use App\Models\Attendance;
use Carbon\Carbon;

class PayrollService
{
    /**
     * 計算特定員工在特定月份的薪資總覽
     */
    public function calculateMonthlyPayroll(User $user, $year, $month)
    {
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        // 取得該月已完成的班次
        $completedShifts = Shift::where('user_id', $user->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->get();

        $totalHours = 0;
        foreach ($completedShifts as $shift) {
            $start = Carbon::parse($shift->scheduled_start);
            $end = Carbon::parse($shift->scheduled_end);
            $diffInHours = $start->diffInHours($end);
            $totalHours += $diffInHours;
        }

        // 異常打卡統計
        $abnormalCount = Attendance::where('user_id', $user->id)
            ->whereBetween('check_time', [$startDate, $endDate])
            ->where('is_abnormal', true)
            ->count();

        // 薪資計算基礎 (這裡可以根據公司合約進行調整)
        $basicSalary = $user->base_salary;
        $overtimePay = 0; // 未來擴充: 根據總時數超過法規的部分計算

        return [
            'user_id' => $user->id,
            'name' => $user->name,
            'employee_id' => $user->employee_id,
            'total_shifts' => $completedShifts->count(),
            'total_hours' => $totalHours,
            'abnormal_count' => $abnormalCount,
            'basic_salary' => $basicSalary,
            'net_pay' => $basicSalary + $overtimePay, // 目前簡化版
        ];
    }
}
