<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/11
 */

namespace App\Controller;


use App\Service\RecordService;
use Hyperf\Di\Annotation\Inject;

class RecordController extends BaseController
{
    /**
     * @Inject()
     * @var RecordService
     */
    protected $recordService;

    /**
     * 消息发送
     * @return bool|string
     */
    public function sendMessage()
    {
        $chat_id = $this->request->input('chat_id', 0);
        $msg = $this->request->input('msg', '');
        try {
            return $this->recordService->sendMessageText($chat_id, $msg);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
