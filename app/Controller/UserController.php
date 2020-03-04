<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/2/27
 */

namespace App\Controller;


use App\Service\UserService;
use Hyperf\Di\Annotation\Inject;

class UserController extends BaseController
{
    /**
     * @Inject()
     * @var UserService
     */
    protected $userService;

    /**
     * 注册用户
     * @return array|string
     */
    public function register()
    {
        try {
            return $this->userService->register($this->request->all());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 用户登录
     * @return array|string
     */
    public function login()
    {
        try {
            return $this->userService->login($this->request->all());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 自动注册用户
     * @return array|string
     */
    public function autoRegister()
    {
        try {
            return $this->userService->autoRegister();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 用户退出
     * @return bool
     */
    public function loginOut()
    {
        $token = $this->request->input('token', '');
        $this->redis->del($token);
        return true;
    }

    /**
     * 根据id获取用户信息
     * @return array|string
     */
    public function findUserById()
    {
        try {
            return $this->userService->findUserById(
                $this->request->input('app_id', 0),
                $this->request->input('id', 0)
            );
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}