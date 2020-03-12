<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/12
 */

namespace App\Model;


class ChatModel extends Model
{
    protected $table = 'chats';

    protected $fillable = [
        'id',           //主键
        'type',         //0:普通单聊,1:群组聊天
        'chat_name',    //聊天室名称
        'creator_id',   //创建者id
        'avatar',       //聊天室头像
        'info',         //聊天室公告
        'status',       //1:正常,0:删除
        'extends',      //扩展字段
        'created_at',   //创建时间
        'updated_at',   //更新时间
    ];

    protected $mongoFields = [
        'id' => 'int',
        'type' => 'int',
        'chat_name' => 'string',
        'creator_id' => 'int',
        'avatar' => 'string',
        'info' => 'string',
        'status' => 'int',
        'extends' => 'string',
    ];

    /**
     * 获取单聊用户的聊天室信息
     * @param  $user_ids
     * @return array
     */
    public function getChatIdByMembers(...$user_ids): array
    {
        $chat = self::query()->leftJoin('chat_members', 'chat_members.chat_id', '=', 'chats.id')
            ->where([
                'chats.type' => 0,
                'chats.status' => 1,
            ])->whereIn('chat_members.user_id', $user_ids)
            ->first();

        return $chat ? $chat->toArray() : [];
    }
}
