# 核心業務邏輯說明書 (Service Logic)

本文件說明系統中最重要的三項後端邏輯：地理圍欄打卡、智慧排班檢查與月度薪資結算。

## 一、 打卡防弊 (Attendance Service)
位於 `app/Services/AttendanceService.php`：
*   **Haversine 公式**：系統會將使用者手機回傳的經緯度與資料庫中 `sites.latitude, longitude` 進行球體距離計算。
*   **異常判定**：若計算結果超過 `sites.radius` (公尺)，則在 `attendances.is_abnormal` 標記為 `true` 並紀錄超出距離。
*   **自動對位**：簽到時系統會自動尋找該員「當日、該站點」最接近的班次並與之連結。

## 二、 智慧排班 (Scheduling Logic)
位於 `app/Livewire/ManagerScheduling.php`：
*   **排班前檢核**：主管儲存排班前，系統會強制執行 `checkConflict()`。
*   **請假檢核**：檢查該保全是否在排班時段已有 `status = approved` (已核准) 的假單。
*   **重複排班檢核**：防止同一保全在同一日被重複指派不同站點。
*   **警告機制**：若有衝突，系統僅顯示警告並禁止儲存，確保人力安排符合實際出勤狀況。

## 三、 月度薪資結算 (Payroll Service)
位於 `app/Services/PayrollService.php`：
*   **工時計算**：僅計算 `status = completed` (已完成) 的班次，依據排定的起迄時間結算總時數。
*   **結算項目**：
    *   `basic_salary`: 來自使用者資料表的底薪。
    *   `abnormal_count`: 當月異常打卡的次數統計。
*   **後端效能**：結算逻辑採用 **Eloquent Eager Loading** (`with(['user', 'shift'])`) 以避免 N+1 效能問題。

## 四、 LINE 通知觸發點
*   **假單核准時**：當主管於 `/manager/leaves` 點擊核准時，`LineService` 會即時對申請保全發出 Push Message。
*   **薪資結算時** (預留)：會計端可手動觸發月度薪資入帳通知。
