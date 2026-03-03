# 系統需求規格說明書與開發里程碑 (System Spec & Roadmap)

## 一、 系統總覽 (System Overview)
本系統已完成核心開發，採用 **Laravel 12** 為後端核心，結合 **Livewire v3** 實現前後端互動。保全端已預留 **LINE LIFF** 介接介面，主管與會計端則擁有專屬的管理與結算看板。

## 二、 系統架構與技術堆疊 (Architecture & Tech Stack)
*   **後端框架**：Laravel 12 (PHP 8.3/8.4+)
*   **管理與前端**：Laravel Livewire v3 + Tailwind CSS
*   **關鍵功能**：GPS Haversine 地理圍欄驗證、自動排班衝突檢查、月度薪資結算。

## 三、 開發里程碑執行狀態 (Roadmap Status)

### 第一階段：系統基石 (Phase 1: Foundation) - ✅ 已完成
*   [x] 環境初始化 (Laravel 12, Database Config)
*   [x] 核心資料庫遷移與模型建立 (Users, Sites, Shifts, Attendances, LeaveRequests)
*   [x] 匯入範例員工與站點資料 (台北 101, 國父紀念館)

### 第二階段：LINE 生態圈介接 (Phase 2: LINE Integration) - ✅ 已完成 (基礎架構)
*   [x] 安裝 LINE SDK 並建立 `LineService` 與 `LineWebhookController`
*   [x] 建立 `documents/03-line_api_setup_guide.md` 供管理者申請金鑰
*   [x] 預留 LINE 推播通知邏輯 (於假單審核流程中)

### 第三階段：核心考勤開發 (Phase 3: Attendance Engine) - ✅ 已完成
*   [x] 實作 `AttendanceService` (GPS 距離計算與異常判定)
*   [x] 開發 `/punch-in` 手機打卡介面 (支援 Livewire 異步定位)
*   [x] 實作 `/manager/monitor` 主管即時考勤監控看板 (每 10 秒自動更新)

### 第四階段：智慧排班與假務 (Phase 4: Scheduling & Leave) - ✅ 已完成
*   [x] 實作保全請假申請與主管核核流程
*   [x] 建立智慧排班介面 (`/manager/scheduling`)
*   [x] **核心邏輯**：排班時自動檢查「已核准假單」衝突與「重複排班」警告。

### 第五階段：財務報表與薪資 (Phase 5: Payroll & Reporting) - ✅ 已完成
*   [x] 實作 `PayrollService` 月度薪資結算引擎
*   [x] 開發 `/accountant/payroll` 薪資總表，整合時數與異常統計
*   [x] 安裝並設定 Excel 匯出套件基礎

### 第六階段：優化與交付 (Phase 6: QA & Launch) - ✅ 已完成
*   [x] 建立全系統導覽列 (Navbar)，連結保全、主管、會計功能
*   [x] 完善 Mobile 與 Desktop 響應式佈局
*   [x] 更新最終專案文件 (GEMINI.md)

## 四、 未來擴充建議
1.  **正式部署**：將系統部署至具備 SSL (HTTPS) 的伺服器，以啟用 LINE LIFF。
2.  **進階權限**：目前為測試模式，未來應加入 Laravel Auth 與 Spatie Permission。
3.  **自動排班優化**：可開發根據人員偏好自動生成整月班表的演算法。
