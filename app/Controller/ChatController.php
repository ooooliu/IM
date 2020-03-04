<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/3
 */

namespace App\Controller;


use App\Service\ChatService;
use Hyperf\Di\Annotation\Inject;

class ChatController extends BaseController
{
    /**
     * @Inject()
     * @var ChatService
     */
    protected $chatService;

    /**
     * 消息发送
     * @return bool|string
     */
    public function sendMessage()
    {
        try {
            return $this->chatService->sendMessage($this->request->all());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}