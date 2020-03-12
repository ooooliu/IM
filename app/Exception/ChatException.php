<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/12
 */

namespace App\Exception;


class ChatException extends BaseException
{
    public function __construct(int $code = 0, string $message = null)
    {
        parent::__construct($code, $message);
    }
}
