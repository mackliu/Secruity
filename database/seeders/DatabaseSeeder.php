<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Site;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. 建立各角色範例帳號
        $users = [
            [
                'name' => '系統管理員',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'employee_id' => 'A001',
            ],
            [
                'name' => '營運主管',
                'email' => 'manager@example.com',
                'role' => 'manager',
                'employee_id' => 'M001',
            ],
            [
                'name' => '財務會計',
                'email' => 'accountant@example.com',
                'role' => 'accountant',
                'employee_id' => 'F001',
            ],
            [
                'name' => '保全小張',
                'email' => 'guard1@example.com',
                'role' => 'security',
                'employee_id' => 'S001',
                'base_salary' => 35000,
                'hourly_rate' => 180,
            ],
            [
                'name' => '保全小李',
                'email' => 'guard2@example.com',
                'role' => 'security',
                'employee_id' => 'S002',
                'base_salary' => 32000,
                'hourly_rate' => 170,
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                array_merge($userData, ['password' => Hash::make('password')])
            );
        }

        // 2. 建立範例站點 (崗位)
        $sites = [
            [
                'name' => '台北101辦公大樓',
                'address' => '台北市信義區信義路五段7號',
                'latitude' => 25.033976,
                'longitude' => 121.564421,
                'radius' => 100,
                'daily_start_time' => '08:00:00',
                'daily_end_time' => '20:00:00',
            ],
            [
                'name' => '國父紀念館站崗',
                'address' => '台北市信義區仁愛路四段505號',
                'latitude' => 25.039454,
                'longitude' => 121.559388,
                'radius' => 50,
                'daily_start_time' => '07:00:00',
                'daily_end_time' => '19:00:00',
            ],
        ];

        foreach ($sites as $siteData) {
            Site::updateOrCreate(['name' => $siteData['name']], $siteData);
        }

        // 3. 建立請假範例資料
        $this->call(LeaveRequestSeeder::class);
    }
}
