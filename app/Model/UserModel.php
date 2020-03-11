<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/2/28
 */

namespace App\Model;


class UserModel extends BaseModel
{
    protected $table = 'users';

    protected $fillable = [
        'id',           //主键
        'mobile',       //手机号码
        'nickname',     //用户昵称
        'password',     //用户密码
        'head_url',     //用户头像
        'app_id',       //用户来源
        'status',       //用户状态
        'created_at',   //创建时间
        'updated_at',   //更新时间
    ];

    protected $mongoFields = [
        'id' => 'int',
        'mobile' => 'string',
        'nickname' => 'string',
        'password' => 'string',
        'head_url' => 'string',
        'app_id' => 'int',
        'status' => 'int'
    ];
}
