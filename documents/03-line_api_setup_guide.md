# LINE API 申請與設定指南 (2026 最新版)

本文件引導您申請「Messaging API」與「LINE Login」所需的金鑰，這對於保全系統的通知功能與 LIFF 應用至關重要。

⚠️ **重要提示**：LINE 官方自 2024 年 9 月 4 日起，Messaging API Channel 和 LIFF App 的建立流程有重大改變。本指南已更新至最新標準。

## 一、 申請流程

### 1. 建立 Provider (供應商)
1.  登入 [LINE Developers Console](https://developers.line.biz/console/)。
2.  點擊 **"Create a new provider"**，輸入您的公司名稱 (例如：`Security Management Co.`)。

### 2. 建立 LINE Official Account 與啟用 Messaging API (用於發送通知)

#### 步驟 2-1：註冊 Business ID
1.  前往 [LINE Business ID 註冊頁面](https://account.line.biz/signup)。
2.  使用 LINE 帳號或電子郵件註冊。

#### 步驟 2-2：建立 LINE Official Account
1.  完成 Business ID 註冊後，填寫 [LINE Official Account 申請表](https://entry.line.biz/form/entry/unverified)。
2.  填入公司名稱、業務類別等必要資訊。
3.  建立完成後，可在 [LINE Official Account Manager](https://manager.line.biz/) 查看帳號。

#### 步驟 2-3：在 Official Account Manager 中啟用 Messaging API
1.  登入 [LINE Official Account Manager](https://manager.line.biz/)。
2.  進入帳號設定，找到 **"Messaging API"** 選項。
3.  點擊 **"啟用"** 或 **"Enable"**。
4.  選擇要綁定的 Provider（此時會建立 Messaging API Channel）。
5.  **重要**：一旦選擇 Provider，日後無法變更。

#### 步驟 2-4：在 Console 中配置 Messaging API Channel
1.  登入 [LINE Developers Console](https://developers.line.biz/console/)，進入剛建立的 Provider。
2.  確認 Messaging API Channel 已建立。
3.  進入該 Channel，點擊 **"Messaging API settings"** 標籤頁：
    *   捲動到最下方，點擊 **"Issue"** 產生 **Channel access token**。
4.  進入 **"Basic settings"** 標籤頁：
    *   找到 **Channel secret**。

### 3. 建立 LINE Login Channel (用於保全登入)
1.  回到 Provider 頁面，點擊 **"Create a new channel"**，選擇 **"LINE Login"**。
2.  填寫必要資訊：
    *   Channel name（不可包含 "LINE" 等相似字眼）
    *   Channel description
    *   Region to provide the service（選擇服務地區）
    *   Company or owner's country/region
    *   Email address
3.  **重要**：在 **"App types"** 勾選 **"Web app"**。
4.  同意 LINE Developers Agreement，點擊建立。

### 4. 建立 LIFF App (用於 LIFF 綁定功能)

⚠️ **重要變更**：LIFF App 不能再添加到 Messaging API Channel 中。只能添加到 LINE Login Channel 或 LINE MINI App Channel。

1.  進入已建立的 **LINE Login Channel**，點擊 **"LIFF"** 標籤頁。
2.  點擊 **"Add"** 建立一個 LIFF App。
3.  填寫 LIFF App 資訊：
    *   **Name**: 應用名稱 (例如：`Security Binding App`)
    *   **Size**: **"Full"** (建議全螢幕模式)
    *   **Endpoint URL**: 填入您的開發或正式伺服器網址 (例如 `https://your-domain.com/liff/binding`)
    *   **Scopes**: 勾選 `profile` 與 `openid`
4.  建立後會得到一個 **LIFF ID** (格式如：`2001234567-abcde123`)。

---

## 二、 需要記錄的金鑰 (請填入 .env)

根據上述步驟，取得以下資訊並填入專案根目錄的 `.env` 檔案。注意：LINE Login Channel 和 Messaging API Channel 的 ID/Secret 不同。

```env
# Messaging API 相關 (用於推送通知)
LINE_MESSAGE_CHANNEL_ID=您的_Messaging_API_Channel_ID
LINE_MESSAGE_CHANNEL_SECRET=您的_Messaging_API_Channel_Secret
LINE_ACCESS_TOKEN=您的_Messaging_API_Access_Token

# LINE Login 相關 (用於登入認證)
LINE_LOGIN_CHANNEL_ID=您的_LINE_Login_Channel_ID
LINE_LOGIN_CHANNEL_SECRET=您的_LINE_Login_Channel_Secret

# LIFF 相關 (用於 LIFF 應用)
LINE_LIFF_ID=您的_LIFF_ID
```

---

## 三、 注意事項

1.  **Provider 與 Channel 的綁定**：
    *   選擇 Provider 後無法變更，請謹慎選擇。
    *   若要同時使用 Messaging API 和 LINE Login，應在同一個 Provider 下建立兩個 Channel。
    *   不同 Provider 的 Channel 會產生不同的 User ID，無法識別同一使用者。

2.  **Webhook 設定**：
    *   在 Messaging API Settings 中，**Webhook URL** 應設定為 `https://your-domain.com/api/line/webhook`。
    *   必須開啟 **"Use webhook"** 選項。

3.  **SSL 憑證**：
    *   LINE API 強制要求 HTTPS。
    *   開發環境建議使用 `ngrok` 或 `Expose` 來對外提供暫時的 HTTPS 網址。
    *   例如：`ngrok http 8000` 取得臨時 HTTPS URL。

4.  **自動回覆**：
    *   建議在 LINE Official Account Manager 中關閉「自動回應訊息」。
    *   改由程式 Webhook 處理所有訊息回應。

5.  **LIFF App 的停止支援**：
    *   官方已停止在 Messaging API 和 Blockchain Service Channel 中新增 LIFF App。
    *   若有舊的 LIFF App 建立在 Messaging API Channel 上，新功能可能無法使用。
    *   建議新增 LIFF App 時建立在 LINE Login 或 LINE MINI App Channel 中。

6.  **LINE MINI App 的推薦（2025 年起）**：
    *   官方自 2025 年 2 月起推薦使用 LINE MINI App 而非 LIFF。
    *   未來 LIFF 會逐步整合至 LINE MINI App 中。
    *   建議長期規劃採用 LINE MINI App。
