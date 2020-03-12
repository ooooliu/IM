<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/12
 */

namespace App\Model;


class ChatMemberModel extends Model
{
    protected $table = 'chat_members';

    protected $fillable = [
        'id',           //主键
        'chat_id',      //聊天室id
        'user_id',      //用户ID
        'remark',       //标签
        'read_time',    //最后一次阅读时间
        'status',       //1:正常,0:退出,2:拉黑
        'extends',      //扩展字段
        'created_at',   //创建时间
        'updated_at',   //更新时间
    ];

    protected $mongoFields = [
        'id' => 'int',
        'chat_id' => 'int',
        'user_id' => 'int',
        'remark' => 'string',
        'read_time' => 'string',
        'status' => 'int',
        'extends' => 'string',
    ];
}
