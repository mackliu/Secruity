<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\AttendanceService;

class AttendanceServiceTest extends TestCase
{
    /**
     * 測試 Haversine 距離公式
     */
    public function test_calculate_distance_between_two_points()
    {
        $service = new AttendanceService();

        // 台北101 (25.033976, 121.564421)
        // 國父紀念館 (25.039454, 121.559388)
        // 實際直線距離約為 780-800 公尺
        
        $distance = $service->calculateDistance(
            25.033976, 121.564421,
            25.039454, 121.559388
        );

        $this->assertGreaterThan(700, $distance);
        $this->assertLessThan(900, $distance);
    }

    /**
     * 測試極近距離 (應接近 0)
     */
    public function test_calculate_distance_same_point()
    {
        $service = new AttendanceService();
        $distance = $service->calculateDistance(25.033, 121.564, 25.033, 121.564);
        
        $this->assertEquals(0, $distance);
    }
}
