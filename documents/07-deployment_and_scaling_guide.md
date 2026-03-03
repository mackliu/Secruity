# 系統部署與多客戶擴展指南 (Deployment & Scaling)

本文件針對「保全管理系統」的生產環境部署提供標準流程，並討論如何將此系統推廣給不同的保全公司客戶。

## 一、 生產環境最低需求
*   **作業系統**：Ubuntu 22.04 LTS 或 Linux 相關發行版。
*   **網頁伺服器**：Nginx (推薦) 或 Apache。
*   **PHP 版本**：PHP 8.3 / 8.4。
    *   必須安裝擴充：`intl`, `bcmath`, `gd`, `zip`, `pdo_mysql`。
*   **資料庫**：MySQL 8.0+。
*   **SSL 憑證**：必須具備 HTTPS (如 Let's Encrypt)，否則 LINE LIFF 無法運作。

## 二、 標準部署流程 (Standard Deployment)
1.  **程式碼佈署**：透過 Git clone 程式碼至伺服器。
2.  **依賴安裝**：
    ```bash
    composer install --optimize-autoloader --no-dev
    npm install && npm run build
    ```
3.  **環境設定**：建立 `.env` 並執行 `php artisan key:generate`。
4.  **資料庫遷移**：執行 `php artisan migrate --force`。
5.  **效能優化** (重要)：
    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```

## 三、 針對不同保全公司的部署策略

當您要將系統賣給 A 公司、B 公司與 C 公司時，有兩種主要策略：

### 策略 A：獨立實例佈署 (推薦，適合初期)
*   **做法**：為每家公司建立獨立的資料庫與獨立的網站目錄（如 `a-security.com`, `b-security.com`）。
*   **優點**：資料完全隔離，安全性最高；各公司可擁有專屬的 LINE 官方帳號金鑰。
*   **缺點**：伺服器維護成本隨客戶增加而上升。

### 策略 B：單一程式、多資料庫 (Multi-tenant)
*   **做法**：使用如 `archtechx/tenancy` 等套件，讓同一份程式碼根據網域自動切換資料庫。
*   **優點**：程式碼更新時一鍵同步所有客戶，維護成本低。
*   **缺點**：系統架構較複雜，需謹慎處理資料隔離。

## 四、 每個客戶必備的獨立設定
無論採用哪種策略，每家保全公司都必須提供以下資料：
1.  **獨立的 LINE 官方帳號**：每家公司應申請自己的 Messaging API 與 LINE Login。
2.  **專屬站點座標**：各公司的服務社區/崗位經緯度不同，需進入後台設定。
3.  **薪資計算參數**：不同公司的勞健保級距與獎懲制度可能微調，需於 `.env` 或資料庫中設定。

## 五、 維護建議與監控
1.  **排程作業 (Cron Job)**：
    *   必須啟動 Laravel Scheduler：`* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`。
    *   這對於自動檢查「逾時未簽到」並發送告警至主管 LINE 至關重要。
2.  **日誌監控**：定期檢查 `storage/logs/laravel.log`，特別是 LINE API 的連線錯誤紀錄。
3.  **備份策略**：建議每日定時備份資料庫 SQL 檔。
