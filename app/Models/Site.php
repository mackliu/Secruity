<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'radius',
        'daily_start_time',
        'daily_end_time',
        'is_active',
    ];

    /**
     * 取得該站點的所有排班
     */
    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }
}
