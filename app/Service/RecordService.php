<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/11
 */

namespace App\Service;


use App\Request\RecordRequest;
use Hyperf\Di\Annotation\Inject;

class RecordService extends BaseService
{
    /**
     * @Inject()
     * @var RecordRequest
     */
    protected $recordRequest;

    /**
     * 发送消息
     * @param array $params
     * @return bool
     */
    public function sendMessage(array $params): bool
    {
        $this->recordRequest->sendMessageValidate($params);

        //两人是否建立聊天关系

        /**
         * @todo 消息体解析业务
         */
        $to = $params['fd'] ?? 0;
        $data = [
            'from_id' => $params['from_id'],
            'to_id' => $params['to_id'],
            'msg' => $params['msg'],
            'type' => 'text',
            'ext' => []
        ];
        $socket = make(WebSocketService::class);
        $socket->send($to, $data);
        return true;
    }

    public function addRecord()
    {

    }
}
