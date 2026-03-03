<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'shift_id',
        'type',
        'check_time',
        'latitude',
        'longitude',
        'distance',
        'is_abnormal',
        'photo_path',
        'remark',
    ];

    protected $casts = [
        'check_time' => 'datetime',
        'is_abnormal' => 'boolean',
    ];

    /**
     * 取得打卡的員工
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 取得對應的排班
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
