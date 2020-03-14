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
     *
     * @return array|string
     */
    public function addChat()
    {
        try {
            return $this->chatService->addChat($this->request->all());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 获取用户聊天室信息
     * @return array|string
     */
    public function getChat()
    {
        try {
            return $this->chatService->getChatList();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     *
     * @return array|string
     */
    public function getChatMembers()
    {
        $from_id = $this->request->input('from_id');
        $to_id = $this->request->input('to_id');
        try {
            return $this->chatService->getChatByMembers($from_id, $to_id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
