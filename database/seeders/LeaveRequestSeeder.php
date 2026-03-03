<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveRequest;
use Carbon\Carbon;

class LeaveRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. 保全小張 (user_id = 4) 的假單
        LeaveRequest::create([
            'user_id' => 4,
            'type' => 'personal',
            'start_time' => Carbon::now()->addDays(2)->setHour(8)->setMinute(0),
            'end_time' => Carbon::now()->addDays(2)->setHour(17)->setMinute(0),
            'reason' => '家裡有事，需要處理搬家事宜。',
            'status' => 'pending',
        ]);

        LeaveRequest::create([
            'user_id' => 4,
            'type' => 'annual',
            'start_time' => Carbon::now()->subDays(5)->setHour(8)->setMinute(0),
            'end_time' => Carbon::now()->subDays(3)->setHour(20)->setMinute(0),
            'reason' => '全家旅遊，請特休三天。',
            'status' => 'approved',
            'approved_by' => 2, // 營運主管核准
        ]);

        // 2. 保全小李 (user_id = 5) 的假單
        LeaveRequest::create([
            'user_id' => 5,
            'type' => 'sick',
            'start_time' => Carbon::now()->subDays(1)->setHour(9)->setMinute(0),
            'end_time' => Carbon::now()->subDays(1)->setHour(18)->setMinute(0),
            'reason' => '急性腸胃炎，需在家休息。',
            'status' => 'rejected',
            'approved_by' => 2,
            'reject_reason' => '請補上醫生診斷證明。',
        ]);

        LeaveRequest::create([
            'user_id' => 5,
            'type' => 'special',
            'start_time' => Carbon::now()->addDays(10)->setHour(13)->setMinute(0),
            'end_time' => Carbon::now()->addDays(10)->setHour(17)->setMinute(0),
            'reason' => '教召點名。',
            'status' => 'pending',
        ]);
    }
}
