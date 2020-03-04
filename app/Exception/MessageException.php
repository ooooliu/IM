<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/2/28
 */

namespace App\Exception;


class MessageException extends BaseException
{
    public function __construct(int $code = 0, string $message = null)
    {
        parent::__construct($code, $message);
    }
}