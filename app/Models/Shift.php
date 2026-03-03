<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = [
        'user_id',
        'site_id',
        'date',
        'scheduled_start',
        'scheduled_end',
        'status',
        'remark',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * 取得該班次的員工
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 取得該班次的站點
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * 取得該班次的考勤紀錄
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
