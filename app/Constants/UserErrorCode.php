<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/2/28
 */

namespace App\Constants;


use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class UserErrorCode extends BaseErrorCode
{
    /**
     * @Message("用户参数有误")
     */
    const USER_PARAMS_ERROR = 20001;

    /**
     * @Message("用户不存在")
     */
    const USER_NOT_FOUND = 20002;

    /**
     * @Message("账户或密码有误")
     */
    const USER_CHECK_ERROR = 20003;

    /**
     * @Message("token失效,请重新登录")
     */
    const USER_TOKEN_NOT_PASS = 20003;
}