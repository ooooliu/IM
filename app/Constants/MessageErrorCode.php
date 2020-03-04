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
class MessageErrorCode extends BaseErrorCode
{
    /**
     * @Message("接收消息有误")
     */
    const RECEIVE_MESSAGE_WRONG = 30001;
}