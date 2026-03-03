# 資料庫設計說明書 (Database Design)

本系統採用 MySQL 8.0+，核心設計邏輯圍繞「員工、站點、班表、考勤」四大維度。

## 一、 核心資料表結構

### 1. users (員工/使用者表)
*   `role`: 區分為 `admin`, `manager`, `accountant`, `security`。
*   `line_user_id`: 儲存來自 LINE 的唯一 ID，用於綁定與推播通知。
*   `base_salary` / `hourly_rate`: 結算薪資的基礎數值。

### 2. sites (站點/崗位表)
*   `latitude`, `longitude`: 站點的中心點座標 (經緯度)。
*   `radius`: 地理圍欄半徑 (預設 100 公尺)。
*   `daily_start_time` / `daily_end_time`: 站點的標準營運時間，用於預設排班。

### 3. shifts (班表)
*   `user_id` / `site_id`: 關聯員工與站點。
*   `date`: 排班日期。
*   `scheduled_start` / `scheduled_end`: 預定的起迄時間。
*   `status`: `scheduled` (已排定), `completed` (已完成), `absent` (曠職)。

### 4. attendances (考勤紀錄)
*   `shift_id`: 關聯班次（若為臨時打卡可為 null）。
*   `type`: `in` (簽到), `out` (簽退)。
*   `distance`: 實際打卡位置與站點中心的距離 (公尺)。
*   `is_abnormal`: 若 `distance` > `sites.radius` 則標記為異常。

### 5. leave_requests (假單)
*   `status`: `pending` (審核中), `approved` (已核准), `rejected` (駁回)。
*   `start_time` / `end_time`: 請假起迄時間。

## 二、 模型關聯 (Eloquent Relationships)

| 模型 | 關聯類型 | 目標模型 | 說明 |
| :--- | :--- | :--- | :--- |
| **User** | hasMany | Shift | 取得員工的所有班表 |
| **User** | hasMany | Attendance | 取得員工的所有打卡紀錄 |
| **User** | hasMany | LeaveRequest | 取得員工的所有假單 |
| **Site** | hasMany | Shift | 取得該站點的所有班表 |
| **Shift** | belongsTo | User | 取得該班次的員工 |
| **Shift** | belongsTo | Site | 取得該班次的站點 |
| **Attendance** | belongsTo | User | 取得打卡的人員 |
| **Attendance** | belongsTo | Shift | 取得對應的班次 |
| **LeaveRequest** | belongsTo | User | 取得申請人 |

## 三、 索引優化 (Indexes)
*   `shifts`: `(user_id, date)` 複合索引，加速個人班表查詢。
*   `attendances`: `(user_id, check_time)` 複合索引，加速月度薪資計算。
*   `leave_requests`: `(user_id, status)` 索引，加速審核與列表顯示。
