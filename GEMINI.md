# ShieldPro: 保全管理系統開發手冊

## 1. 專案概述 (Project Overview)
本系統是一套基於 **Laravel 12** 的企業級保全管理平台，旨在透過數位化手段解決保全業的考勤防弊、智慧排班與薪資自動結算問題。系統具備高度響應式設計，完美適配手機（LIFF）與桌面端。

## 2. 技術堆疊 (Technical Stack)
*   **後端框架**：Laravel 12 (PHP 8.3+)
*   **前端互動**：Laravel Livewire v3 (純 PHP 驅動的 SPA 體驗)
*   **樣式引擎**：Tailwind CSS v4 (採用最新 Vite 整合插件)
*   **資料庫**：MySQL 8.0+
*   **構建工具**：Vite 7.0+
*   **第三方整合**：LINE Messaging API / LINE Login (LIFF)

## 3. 核心功能與開發成果
*   **保全端**：
    *   GPS 智能打卡：結合瀏覽器定位 API 與 Haversine 距離演算法，自動判定地理圍欄異常。
    *   請假申請：線上提交假單，即時查看審核進度。
*   **主管端**：
    *   即時監控看板：每 10 秒自動刷新，動態標註異常打卡紀錄。
    *   假單審核中心：一鍵核准/駁回，整合 LINE Service 即時推播。
    *   智慧排班：自動檢查「請假衝突」與「重複排班」，降低調度錯誤。
*   **會計端**：
    *   薪資結算引擎：自動統計當月工時、完成班次與異常次數。
    *   報表中心：整合 `maatwebsite/excel` 提供基礎匯出架構。

## 4. 前端編譯與樣式開發 (重要)
本專案已從 CDN 遷移至 **本地 Vite 編譯** 環境，請開發者注意：
*   **開發模式**：執行 `npm run dev` 進行即時預覽。
*   **生產編譯**：部署前必須執行 `npm run build`。
*   **Tailwind v4**：不使用 `tailwind.config.js`，所有設定（動畫、變數）皆定義於 `resources/css/app.css`。
*   **佈局檔案**：統一使用 `resources/views/layouts/app.blade.php`，同時支援 `@yield` 與 `$slot`。

## 5. 開發者快速啟動
1.  **資料庫設定**：於 `.env` 設定資料庫連線。
2.  **初始化**：
    ```bash
    composer install
    npm install
    php artisan migrate --seed
    npm run build
    ```
3.  **測試帳號**：
    *   管理員/主管：`manager@example.com` / `password`
    *   保全人員：`guard1@example.com` / `password`

## 6. 注意事項與後續擴充
*   **HTTPS 需求**：LINE LIFF 功能強制要求 SSL 憑證，開發測試建議使用 `ngrok`。
*   **LINE 金鑰**：請參考 `documents/03-line_api_setup_guide.md` 填入 `.env`。
*   **權限控管**：目前系統為「開放測試模式」，生產環境建議加入 `Middleware` 或 `Spatie Permission` 套件。
*   **部署建議**：針對不同客戶，建議採用「獨立實例」部署以確保資料安全，詳見 `documents/07-deployment_and_scaling_guide.md`。

## 7. 相關文件目錄
*   `documents/01-user_stories.md` - 需求分析
*   `documents/02-system_spec_and_roadmap.md` - 開發進度
*   `documents/04-database_design.md` - 資料庫設計
*   `documents/05-service_logic_documentation.md` - 核心邏輯
