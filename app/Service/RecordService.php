<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/11
 */

namespace App\Service;


class RecordService extends BaseService
{
    /**
     * 发送消息
     * @param array $params
     * @return bool
     */
    public function sendMessage(array $params): bool
    {
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
}
