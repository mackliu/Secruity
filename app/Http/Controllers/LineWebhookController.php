<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LINE\Parser\EventRequestParser;
use App\Models\User;

class LineWebhookController extends Controller
{
    /**
     * 處理來自 LINE 的 Webhook 事件
     */
    public function handle(Request $request)
    {
        $signature = $request->header('x-line-signature');
        $channelSecret = config('line.channel_secret');

        if (empty($signature) || empty($channelSecret)) {
            Log::warning("LINE Webhook 缺少簽名或 Secret，暫時跳過驗證。");
        }

        $events = $request->input('events', []);

        foreach ($events as $event) {
            $this->processEvent($event);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * 處理單一事件
     */
    protected function processEvent($event)
    {
        $type = $event['type'] ?? '';
        $lineUserId = $event['source']['userId'] ?? null;

        if (!$lineUserId) return;

        switch ($type) {
            case 'message':
                // 未來可實作: 傳送特定關鍵字觸發打卡
                break;
            case 'follow':
                // 使用者加入好友，未來可傳送綁定連結
                Log::info("新使用者加入 LINE 好友: " . $lineUserId);
                break;
            case 'unfollow':
                // 使用者封鎖，將 line_user_id 設為 null
                User::where('line_user_id', $lineUserId)->update(['line_user_id' => null]);
                break;
        }
    }
}
