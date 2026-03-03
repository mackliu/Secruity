# 維護與後續開發說明書 (Maintenance & Expansion)

本文件提供給維護工程師，說明如何進行環境管理、增加功能與系統測試。

## 一、 環境啟動
1.  **資料庫**：確保 MySQL 連線正確，執行 `php artisan migrate --seed` 建立基礎資料。
2.  **開發伺服器**：執行 `php artisan serve` 啟動 Laravel。
3.  **前端編譯**：本系統目前採用 Tailwind CDN 以方便開發。上線前建議執行 `npm install` 與 `npm run build`。

## 二、 角色與權限調整 (RBAC)
本系統目前為測試模式，所有頁面皆可連結。未來建議進行以下調整：
*   **增加 Middleware**：於 `routes/web.php` 中為 `manager` 與 `accountant` 加上角色檢查。
*   **建議套件**：使用 `spatie/laravel-permission` 進行細粒度的權限控管。

## 三、 LINE LIFF 串接關鍵點
*   **HTTPS 需求**：LINE 強制要求 Webhook 與 LIFF URL 必須是 HTTPS。
*   **Webhook 測試**：推薦使用 `ngrok` (例：`ngrok http 8000`) 將本地端環境轉為外部網址進行測試。
*   **金鑰儲存**：請確保 `.env` 中的 `LINE_CHANNEL_SECRET` 等金鑰不被外流。

## 四、 常見開發需求
### 1. 增加新的打卡異常判定邏輯
*   修改 `app/Services/AttendanceService.php` 中的 `recordAttendance` 方法。

### 2. 增加薪資計算項 (如全勤獎金)
*   修改 `app/Services/PayrollService.php` 結算公式，並更新 `app/Livewire/PayrollSummary.php` 的顯示欄位。

### 3. 排班表拖拉功能
*   目前為下拉式選擇。若需實現拖拉介面，建議整合 `livewire-sortable` 相關套件。
