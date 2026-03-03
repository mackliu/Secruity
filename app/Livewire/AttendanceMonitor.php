<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;
use Livewire\WithPagination;

class AttendanceMonitor extends Component
{
    use WithPagination;

    /**
     * 每 10 秒自動重新整理資料
     */
    public function render()
    {
        $attendances = Attendance::with(['user', 'shift.site'])
            ->orderBy('check_time', 'desc')
            ->paginate(15);

        return view('livewire.attendance-monitor', [
            'attendances' => $attendances
        ]);
    }
}
