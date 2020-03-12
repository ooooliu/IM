<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/12
 */

namespace App\Constants;


use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class ChatErrorCode extends BaseErrorCode
{
    /**
     * @Message("参数有误")
     */
    const PARAMS_ERROR = 40001;

    /**
     * @Message("开启聊天失败")
     */
    const ADD_CHAT_FAIL = 40002;

    /**
     * @Message("开启聊天失败")
     */
    const ADD_CHAT_MEMBER_FAIL = 40003;

}
