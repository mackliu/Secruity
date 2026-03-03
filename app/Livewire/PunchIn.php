<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Site;
use App\Models\User;
use App\Services\AttendanceService;
use Illuminate\Support\Facades\Auth;

class PunchIn extends Component
{
    public $sites;
    public $selectedSite;
    public $lat, $lon;
    public $statusMessage;
    public $isError = false;

    public function mount()
    {
        $this->sites = Site::where('is_active', true)->get();
        // 如果有排班，可以預設選擇該站點
        $this->selectedSite = $this->sites->first()?->id;
    }

    /**
     * 接收前端傳來的 GPS 資料
     */
    public function setLocation($lat, $lon)
    {
        $this->lat = $lat;
        $this->lon = $lon;
    }

    /**
     * 執行簽到
     */
    public function punch($type)
    {
        if (!$this->lat || !$this->lon) {
            $this->statusMessage = "無法取得 GPS 定位，請確保開啟手機定位功能。";
            $this->isError = true;
            return;
        }

        $service = new AttendanceService();
        
        try {
            // 目前測試先模擬 user_id = 4 (保全小張)，之後整合 LINE 登入後改用 Auth::user()
            $user = User::find(4); 
            
            $record = $service->recordAttendance($user, $this->selectedSite, $type, $this->lat, $this->lon);
            
            if ($record->is_abnormal) {
                $this->statusMessage = "打卡成功，但檢測到地點異常：" . $record->remark;
                $this->isError = true;
            } else {
                $this->statusMessage = ($type == 'in' ? '簽到' : '簽退') . "成功！位置在範圍內。";
                $this->isError = false;
            }
        } catch (\Exception $e) {
            $this->statusMessage = "系統錯誤: " . $e->getMessage();
            $this->isError = true;
        }
    }

    public function render()
    {
        return view('livewire.punch-in');
    }
}
