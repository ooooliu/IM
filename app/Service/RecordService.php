<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/11
 */

namespace App\Service;


use App\Constants\ChatErrorCode;
use App\Exception\ChatException;
use App\Model\ChatMemberModel;
use App\Model\RecordModel;
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
     * @Inject()
     * @var ChatMemberModel
     */
    protected $chatMember;

    /**
     * @Inject()
     * @var RecordModel
     */
    protected $recordMo;

    /**
     * 发送消息
     * @param int $chat_id
     * @param $msg
     * @return bool
     */
    public function sendMessageText(int $chat_id, string $msg): bool
    {
        $this->recordRequest->sendMessageValidate([
            'chat_id' => $chat_id,
            'msg' => $msg,
        ]);
        $user_id = $this->auth()['id'];
        //获取chat成员
        $member = $this->chatMember->getOtherMember($chat_id, $user_id);
        if (empty($member)) {
            throw new ChatException(ChatErrorCode::CHAT_IS_NULL);
        }

        $socket = make(WebSocketService::class);
        foreach ($member as $value) {
            $res = $socket->send($value['user_id'], $msg);
            if ($res) {
                //异步保存聊天信息
                go($this->addRecord([
                    'chat_id' => $chat_id,
                    'from_id' => $user_id,
                    'type' => 'text',
                    'msg' => $msg,
                ]));
            }
        }
        return true;
    }

    /**
     * 添加消息记录
     * @param array $params
     * @return array
     */
    public function addRecord(array $params): array
    {
        return $this->recordMo->addOne([
            'chat_id' => $params['chat_id'] ?? 0,
            'from_id' => $params['from_id'] ?? 0,
            'type' => $params['type'] ?? 'text',
            'msg' => $params['msg'] ?? '',
        ]);
    }

    /**
     * 获取聊天记录
     * @param int $chat_id
     * @param array $params
     * @return array
     */
    public function getRecord(int $chat_id, array $params): array
    {
        $where = [
            'chat_id' => $chat_id,
            'status' => 0
        ];
        if (isset($params['from_id'])) {
            $where['from_id'] = $params['from_id'];
        }
        if (isset($params['type'])) {
            $where['type'] = $params['type'];
        }
        return $this->recordMo->findAll($where);
    }
}
