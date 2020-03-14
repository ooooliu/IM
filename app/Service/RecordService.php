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
    protected $record;

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
            $socket->send($value['user_id'], $msg);
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
        return $this->record->addOne([
            'chat_id' => $params['chat_id'] ?? 0,
            'from_id' => $params['from_id'] ?? 0,
            'type' => $params['type'] ?? 'text',
            'msg' => $params['msg'] ?? '',
        ]);
    }
}
