<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/2
 */

namespace App\Controller;


use Hyperf\Di\Annotation\Inject;

class BaseController extends AbstractController
{
    /**
     * @Inject()
     * @var \Redis
     */
    protected $redis;

    /**
     * 获取登录用户信息
     * @return array
     */
    protected function auth(): array
    {
        $token = $this->request->input('token');
        return $token ? $this->redis->hMGet($token, [
            'id', 'mobile', 'app_id'
        ]) : [];
    }
}