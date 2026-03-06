<?php

namespace App\Services;

use App\Models\Site;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class AttendanceService
{
    /**
     * 計算兩個 GPS 點之間的距離 (公尺)
     * 使用 Haversine 公式
     */
    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // 地球半徑 (公尺)

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * 執行簽到/退邏輯
     * @param bool $force 是否強制手動簽到
     */
    public function recordAttendance(User $user, $siteId, $type, $lat, $lon, $photoPath = null, $force = false)
    {
        $site = Site::find($siteId);
        if (!$site) throw new \Exception("找不到該站點");

        // 若有座標，計算距離與判定異常；若無座標，標記為強制異常
        if ($lat !== null && $lon !== null) {
            $distance = $this->calculateDistance($lat, $lon, $site->latitude, $site->longitude);
            $isAbnormal = $distance > $site->radius;
            $remark = $isAbnormal ? "超出地理圍欄範圍 (" . round($distance) . "m)" : null;
        } else {
            $distance = 0;
            $isAbnormal = true; // 強制手動簽到一律視為異常（需事後審核）
            $remark = "無 GPS 訊號 (手動強制簽到)";
        }

        // 找尋對應的排班 (當天最接近的班次)
        $shift = $user->shifts()
            ->where('site_id', $siteId)
            ->where('date', Carbon::today()->toDateString())
            ->first();

        $attendance = Attendance::create([
            'user_id' => $user->id,
            'shift_id' => $shift ? $shift->id : null,
            'type' => $type,
            'check_time' => now(),
            'latitude' => $lat,
            'longitude' => $lon,
            'distance' => round($distance),
            'is_abnormal' => $isAbnormal,
            'photo_path' => $photoPath,
            'remark' => $remark,
        ]);

        // 異常通知主管
        if ($isAbnormal) {
            $lineService = app(LineService::class);
            $managers = User::where('role', 'manager')->whereNotNull('line_user_id')->get();
            $msg = "⚠️ 打卡異常警示 (" . ($lat ? "超出圍欄" : "手動強制") . ")\n" .
                   "員工: {$user->name} ({$user->employee_id})\n" .
                   "站點: {$site->name}\n" .
                   "備註: {$remark}";
            
            foreach ($managers as $manager) {
                $lineService->sendTextMessage($manager->line_user_id, $msg);
            }
        }

        return $attendance;
    }
}
