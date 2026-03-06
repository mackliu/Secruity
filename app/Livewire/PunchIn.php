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
     * @param string $type 'in' 或 'out'
     * @param bool $force 是否強制手動簽到 (無 GPS)
     */
    public function punch($type, $force = false)
    {
        if (!$force && (!$this->lat || !$this->lon)) {
            $this->statusMessage = "無法取得 GPS 定位，若環境不允許 GPS，請使用下方『手動簽到』功能。";
            $this->isError = true;
            return;
        }

        $service = new AttendanceService();
        
        try {
            // 使用目前登入的使用者
            $user = Auth::user(); 
            
            // 如果是強制手動簽到，傳入 null 的座標
            $record = $service->recordAttendance(
                $user, 
                $this->selectedSite, 
                $type, 
                $force ? null : $this->lat, 
                $force ? null : $this->lon,
                null,
                $force // 傳入 force 標記
            );
            
            if ($record->is_abnormal) {
                $this->statusMessage = "打卡成功（已標記為手動核核）：" . $record->remark;
                $this->isError = true;
            } else {
                $this->statusMessage = ($type == 'in' ? '簽到' : '簽退') . "成功！";
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
