<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/11
 */

namespace App\Model;


class RecordModel extends MongoModel
{
    protected $table = 'records';

    protected $fillable = [
        'id',           //主键
        'chat_id',      //聊天室id
        'from_id',      //发送者id
        'type',         //消息类型
        'msg',          //聊天内容
        'status',       //用户状态 0:正常 1:删除 2:撤回 3:屏蔽
        'extends',      //扩展字段
        'created_at',   //创建时间
        'updated_at',   //更新时间
    ];

    protected $mongoFields = [
        'id' => 'int',
        'chat_id' => 'int',
        'from_id' => 'int',
        'type' => 'int',
        'msg' => 'string',
        'status' => 'int',
        'extends' => 'string',
    ];
}
