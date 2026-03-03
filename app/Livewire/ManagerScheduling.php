<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Site;
use App\Models\Shift;
use App\Models\LeaveRequest;
use Carbon\Carbon;

class ManagerScheduling extends Component
{
    public $guards, $sites;
    public $selectedGuard, $selectedSite, $date, $start_time, $end_time;
    public $conflictMessage = '';
    public $statusMessage = '';

    public function mount()
    {
        $this->guards = User::where('role', 'security')->where('is_active', true)->get();
        $this->sites = Site::where('is_active', true)->get();
        $this->date = Carbon::now()->addDay()->toDateString();
        $this->start_time = '08:00';
        $this->end_time = '20:00';
        
        $this->selectedGuard = $this->guards->first()?->id;
        $this->selectedSite = $this->sites->first()?->id;
    }

    /**
     * 檢查是否有排班衝突
     */
    public function checkConflict()
    {
        $this->conflictMessage = '';
        $start = Carbon::parse($this->date . ' ' . $this->start_time);
        $end = Carbon::parse($this->date . ' ' . $this->end_time);

        // 1. 檢查已核准假單衝突
        $leaveConflict = LeaveRequest::where('user_id', $this->selectedGuard)
            ->where('status', 'approved')
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_time', [$start, $end])
                      ->orWhereBetween('end_time', [$start, $end])
                      ->orWhere(function ($q) use ($start, $end) {
                          $q->where('start_time', '<=', $start)
                            ->where('end_time', '>=', $end);
                      });
            })->exists();

        if ($leaveConflict) {
            $this->conflictMessage = "警告：該員在此時段已有『已核准』的假單！";
            return true;
        }

        // 2. 檢查重複排班衝突
        $shiftConflict = Shift::where('user_id', $this->selectedGuard)
            ->where('date', $this->date)
            ->where(function ($query) use ($start, $end) {
                // 這裡簡化檢查同日是否有重疊時段
                $query->whereBetween('scheduled_start', [$this->start_time, $this->end_time])
                      ->orWhereBetween('scheduled_end', [$this->start_time, $this->end_time]);
            })->exists();

        if ($shiftConflict) {
            $this->conflictMessage = "警告：該員在此日已有其他排班！";
            return true;
        }

        return false;
    }

    /**
     * 儲存排班
     */
    public function saveShift()
    {
        if ($this->checkConflict()) return;

        Shift::create([
            'user_id' => $this->selectedGuard,
            'site_id' => $this->selectedSite,
            'date' => $this->date,
            'scheduled_start' => $this->start_time,
            'scheduled_end' => $this->end_time,
            'status' => 'scheduled',
        ]);

        $this->statusMessage = "排班成功！";
        $this->dispatch('shift-updated');
    }

    public function render()
    {
        $recentShifts = Shift::with(['user', 'site'])
            ->where('date', '>=', Carbon::today())
            ->orderBy('date', 'asc')
            ->get();

        return view('livewire.manager-scheduling', [
            'recentShifts' => $recentShifts
        ]);
    }
}
