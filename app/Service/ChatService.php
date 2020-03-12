<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/3
 */

namespace App\Service;


use App\Constants\ChatErrorCode;
use App\Exception\ChatException;
use App\Model\ChatMemberModel;
use App\Model\ChatModel;
use App\Request\ChatRequest;
use Hyperf\Di\Annotation\Inject;

class ChatService extends BaseService
{
    /**
     * @Inject()
     * @var ChatRequest
     */
    protected $chatRequest;

    /**
     * @Inject()
     * @var ChatModel
     */
    protected $chatMo;

    /**
     * @Inject()
     * @var ChatMemberModel
     */
    protected $chatMemberMo;

    /**
     *
     * @param array $params
     * @return array|string
     */
    public function addChat(array $params): array
    {
        $this->chatRequest->addChatValidate($params);

        try {
            //创建聊天关系
            $chat = $this->chatMo->addOne([
                'type' => 0,
                'chat_name' => '',
                'creator_id' => $this->auth()['id'],
                'avatar' => '',
                'info' => '',
                'status' => 1,
                'extends' => '',
            ]);

            if (empty($chat['id'])) {
                throw new ChatException(ChatErrorCode::ADD_CHAT_FAIL);
            }

            //添加聊天室成员
            $res = $this->chatMemberMo->addAll([
                [
                    'chat_id' => $chat['id'],
                    'user_id' => $this->auth()['id'],
                    'remark' => '',
                    'read_time' => date('Y-m-d H:i:s'),
                    'status' => 1,
                    'extends' => '',
                ],
                [
                    'chat_id' => $chat['id'],
                    'user_id' => $params['to_id'],
                    'remark' => '',
                    'read_time' => date('Y-m-d H:i:s'),
                    'status' => 1,
                    'extends' => '',
                ]
            ]);

            if (!$res) {
                throw new ChatException(ChatErrorCode::ADD_CHAT_MEMBER_FAIL);
            }
            return $chat;
        } catch (ChatException $e) {
            return $e->getMessage();
        }
    }

    /**
     * 获取单聊用户的聊天室信息
     * @param int $from_id
     * @param int $to_id
     * @return array
     */
    public function getChatIdByMembers(int $from_id, int $to_id): array
    {
        $this->chatRequest->findChatValidate($from_id, $to_id);

        return $this->chatMo->getChatIdByMembers($from_id, $to_id);
    }
}
