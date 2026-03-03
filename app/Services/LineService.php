<?php

namespace App\Services;

use LINE\Clients\MessagingApi\Api\MessagingApiApi;
use LINE\Clients\MessagingApi\Configuration;
use GuzzleHttp\Client;
use LINE\Clients\MessagingApi\Model\PushMessageRequest;
use LINE\Clients\MessagingApi\Model\TextMessage;

class LineService
{
    protected $messagingApi;

    public function __construct()
    {
        $config = new Configuration();
        $config->setAccessToken(config('line.access_token'));
        
        $client = new Client();
        $this->messagingApi = new MessagingApiApi($client, $config);
    }

    /**
     * 發送簡單文字訊息給單一使用者
     * 
     * @param string $toLineId 使用者的 line_user_id
     * @param string $text 訊息內容
     */
    public function sendTextMessage($toLineId, $text)
    {
        if (empty($toLineId)) return;

        $message = new TextMessage(['type' => 'text', 'text' => $text]);
        $request = new PushMessageRequest([
            'to' => $toLineId,
            'messages' => [$message],
        ]);

        try {
            $this->messagingApi->pushMessage($request);
            return true;
        } catch (\Exception $e) {
            \Log::error("LINE 發送失敗: " . $e->getMessage());
            return false;
        }
    }

    /**
     * 未來擴充: 發送薪資單或排班通知 (Flex Message)
     */
    public function sendFlexMessage($toLineId, $altText, $contents)
    {
        // 實作邏輯...
    }
}
