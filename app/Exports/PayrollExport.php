<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PayrollExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;
    protected $year;
    protected $month;

    public function __construct($data, $year, $month)
    {
        $this->data = $data;
        $this->year = $year;
        $this->month = $month;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            '員工姓名',
            '員工編號',
            '計薪月份',
            '底薪',
            '總工時',
            '異常次數',
            '應領薪資'
        ];
    }

    public function map($payroll): array
    {
        return [
            $payroll['name'],
            $payroll['employee_id'],
            $this->year . '-' . str_pad($this->month, 2, '0', STR_PAD_LEFT),
            $payroll['basic_salary'],
            $payroll['total_hours'],
            $payroll['abnormal_count'],
            $payroll['net_pay'],
        ];
    }
}
