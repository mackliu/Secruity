# LINE API 申請與設定指南 (2024 最新版)

本文件引導您申請「Messaging API」與「LINE Login」所需的金鑰，這對於保全系統的通知功能與 LIFF 綁定至關重要。

## 一、 申請流程

### 1. 建立 Provider (供應商)
1.  登入 [LINE Developers Console](https://developers.line.biz/console/)。
2.  點擊 **"Create a new provider"**，輸入您的公司名稱 (例如：`Security Management Co.`)。

### 2. 建立 Messaging API Channel (用於發送通知)
1.  在該 Provider 下，點擊 **"Create a Messaging API channel"**。
2.  填寫基本資訊 (名稱、描述、分類)。
3.  建立完成後，進入 **"Messaging API settings"** 標籤頁：
    *   捲動到最下方，點擊 **"Issue"** 產生 **Channel access token**。
4.  進入 **"Basic settings"** 標籤頁：
    *   找到 **Channel secret**。

### 3. 建立 LINE Login Channel (用於保全登入與綁定)
1.  回到 Provider 頁面，點擊 **"Create a new channel"**，選擇 **"LINE Login"**。
2.  **重要**：在 "App types" 勾選 **Web app**。
3.  建立完成後，進入 **"LIFF"** 標籤頁：
    *   點擊 **"Add"** 建立一個 LIFF App。
    *   **Size**: Full (建議全螢幕)。
    *   **Endpoint URL**: 填入您的開發或正式伺服器網址 (例如 `https://your-domain.com/liff/binding`)。
    *   **Scopes**: 勾選 `profile` 與 `openid`。
4.  建立後會得到一個 **LIFF ID** (格式如：`2001234567-abcde123`)。

---

## 二、 需要記錄的金鑰 (請填入 .env)

取得後請將以下資訊填入專案根目錄的 `.env` 檔案中：

```env
LINE_CHANNEL_ID=你的_Channel_ID
LINE_CHANNEL_SECRET=你的_Channel_Secret
LINE_ACCESS_TOKEN=你的_Messaging_API_Access_Token
LINE_LIFF_ID=你的_LIFF_ID
```

---

## 三、 注意事項

1.  **Webhook 設定**：
    *   在 Messaging API 標籤頁中，**Webhook URL** 應設定為 `https://your-domain.com/api/line/webhook`。
    *   必須開啟 **"Use webhook"** 選項。
2.  **SSL 憑證**：LINE API 強制要求 HTTPS，開發環境建議使用 `ngrok` 或 `Expose` 來對外提供暫時的 HTTPS 網址。
3.  **自動回覆**：建議在 LINE Official Account Manager 中關閉「自動回應訊息」，改由我們的程式 Webhook 處理。
