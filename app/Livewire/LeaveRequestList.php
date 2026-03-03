<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LeaveRequest;
use App\Models\User;
use Carbon\Carbon;

class LeaveRequestList extends Component
{
    public $type = 'personal';
    public $start_time, $end_time, $reason;
    public $statusMessage;

    public function mount()
    {
        $this->start_time = Carbon::now()->addDay()->format('Y-m-d\T08:00');
        $this->end_time = Carbon::now()->addDay()->format('Y-m-d\T20:00');
    }

    /**
     * 提交請假申請
     */
    public function submitRequest()
    {
        $this->validate([
            'type' => 'required',
            'start_time' => 'required|after:now',
            'end_time' => 'required|after:start_time',
            'reason' => 'required|min:5',
        ]);

        // 模擬當前使用者為保全小張 (user_id = 4)
        $user = User::find(4);

        LeaveRequest::create([
            'user_id' => $user->id,
            'type' => $this->type,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'reason' => $this->reason,
            'status' => 'pending',
        ]);

        $this->statusMessage = "假單已送出，等待主管審核。";
        $this->reset(['reason']);
    }

    public function render()
    {
        // 模擬當前使用者為保全小張 (user_id = 4)
        $myRequests = LeaveRequest::where('user_id', 4)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.leave-request-list', [
            'myRequests' => $myRequests
        ]);
    }
}
