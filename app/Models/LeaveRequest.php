<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'start_time',
        'end_time',
        'reason',
        'attachment_path',
        'status',
        'approved_by',
        'reject_reason',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * 取得申請人
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 取得審核人
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
