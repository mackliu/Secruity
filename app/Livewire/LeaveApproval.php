<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LeaveRequest;
use App\Services\LineService;
use Illuminate\Support\Facades\Log;

class LeaveApproval extends Component
{
    public $rejectReason = [];

    /**
     * 核准假單
     */
    public function approve($requestId)
    {
        $request = LeaveRequest::find($requestId);
        if (!$request) return;

        // 模擬當前使用者為主管 (user_id = 2)
        $request->update([
            'status' => 'approved',
            'approved_by' => 2,
        ]);

        // 發送 LINE 通知 (若有綁定 LINE)
        if ($request->user->line_user_id) {
            $line = new LineService();
            $line->sendTextMessage(
                $request->user->line_user_id, 
                "您的假單已核准！時段：{$request->start_time->format('m/d H:i')} - {$request->end_time->format('m/d H:i')}"
            );
        }

        session()->flash('message', "已核准 {$request->user->name} 的假單。");
    }

    /**
     * 駁回假單
     */
    public function reject($requestId)
    {
        $reason = $this->rejectReason[$requestId] ?? '未註明原因';
        $request = LeaveRequest::find($requestId);
        if (!$request) return;

        $request->update([
            'status' => 'rejected',
            'approved_by' => 2,
            'reject_reason' => $reason,
        ]);

        session()->flash('message', "已駁回 {$request->user->name} 的假單。");
    }

    public function render()
    {
        $pendingRequests = LeaveRequest::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('livewire.leave-approval', [
            'pendingRequests' => $pendingRequests
        ]);
    }
}
