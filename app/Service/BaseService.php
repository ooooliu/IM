<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/2/28
 */

namespace App\Service;


use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

class BaseService
{
    /**
     * @Inject()
     * @var \Redis
     */
    protected $redis;

    /**
     * @var int
     */
    protected $code = 200;

    /**
     * 获取登录用户信息
     * @return array
     */
    protected function auth(): array
    {
        $token = make(RequestInterface::class)->input('token', '');

        if (!empty($token)) {
            $auth = $this->redis->hMGet($token, [
                'id', 'mobile', 'nickname', 'app_id', 'head_url'
            ]);
        }
        return empty($auth) ? [] : $auth;
    }
}