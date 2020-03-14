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
    public function getChatByMembers(int $from_id, int $to_id): array
    {
        $this->chatRequest->findChatValidate($from_id, $to_id);

        return $this->chatMo->getChatByMembers($from_id, $to_id);
    }

    /**
     * 根据用户id获取用户聊天室信息
     * @return array
     */
    public function getChatList(): array
    {
        return $this->chatMo->getChatByUserId($this->auth()['id']);
    }

    /**
     * 更新聊天室信息
     * @param array $params
     * @return bool
     */
    public function updateChat(array $params): bool
    {
        $where = [
            'id' => $params['chat_id'] ?? 0
        ];
        if (isset($params['chat_name'])) {
            $value['chat_name'] = $params['chat_name'];
        }
        if (isset($params['avatar'])) {
            $value['avatar'] = $params['avatar'];
        }
        if (isset($params['info'])) {
            $value['info'] = $params['info'];
        }
        if (!empty($value)) {
            $this->chatMo->updateOne($where, $value);
        }
        return true;
    }

    /**
     * 删除聊天室
     * @param array $params
     * @return bool
     */
    public function deleteChat(array $params): bool
    {
        $this->chatMo->updateOne([
            'id' => $params['chat_id'] ?? 0
        ], [
            'status' => 0
        ]);
        return true;
    }

    /**
     * 更新用户消息已读时间
     * @param int $chat_id
     * @param int $user_id
     * @return bool
     */
    public function readMessage(int $chat_id, int $user_id): bool
    {
        $this->chatMemberMo->updateOne([
            'chat_id' => $chat_id,
            'user_id' => $user_id,
        ], [
            'read_time' => date('Y-m-d H:i:s')
        ]);
        return true;
    }

}
