<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/2/28
 */

namespace App\Exception;


use Hyperf\Server\Exception\ServerException;

class BaseException extends ServerException
{
    public function __construct(int $code = 0, string $message = null, \Throwable $previous = null)
    {
        if (is_null($message)) {
            $class_name = str_replace(
                'Exception',
                'ErrorCode',
                last(explode('\\', get_called_class()))
            );
            $class = '\\App\\Constants\\'.$class_name;

            if (class_exists($class)) {
                $message = make($class)::getMessage($code);
            } else {
                $message = 'Class Not Found';
            }
        }
        parent::__construct($message, $code, $previous);
    }
}