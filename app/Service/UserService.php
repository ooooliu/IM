<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/2/28
 */

namespace App\Service;


use App\Constants\UserErrorCode;
use App\Exception\UserException;
use App\Model\UserModel;
use App\Request\UserRequest;
use App\Utils\Common;
use Hyperf\Di\Annotation\Inject;

class UserService extends BaseService
{
    /**
     * @Inject()
     * @var UserRequest
     */
    protected $userRequest;

    /**
     * @Inject()
     * @var UserModel
     */
    protected $userMo;

    /**
     * 注册用户
     * @param array $params
     * @return array
     */
    public function register(array $params): array
    {
        //用户注册验证
        $this->userRequest->addUserValidate($params);

        return $this->userMo->addOne($params);
    }

    /**
     * 自动注册用户
     * @return array
     */
    public function autoRegister(): array
    {
        $common = make(Common::class);
        //随机创建手机号码
        $mobile = $common->getRandMobile();

        //随机生成用户名
        $string = $common->getRandChar(6);

        //随机创建头像
        $avatar = ['a1.jpg', 'a2.jpg', 'a3.jpg', 'a4.jpg', 'a5.jpg', 'a6.jpg', 'a7.jpg', 'a8.jpg', 'a9.jpg', 'a10.jpg'];
        $header_img = $avatar[mt_rand(0, 9)];

        $params = [
            'mobile' => $mobile,
            'nickname' => 'user_' . $string,
            'password' => md5('123456'),
            'head_url' => $header_img,
            'app_id' => '200001',
            'status' => 1,
        ];
        return $this->userMo->addOne($params);
    }

    /**
     * 用户登录
     * @param array $params
     * @return array
     */
    public function login(array $params): array
    {
        //用户登录验证
        $this->userRequest->signInValidate($params);
        $data = [
            'mobile' => $params['mobile'],
            'app_id' => $params['app_id'],
        ];
        //获取用户信息
        $user = $this->userMo->findOne($data);
        if (empty($user)) {
            throw new UserException(UserErrorCode::USER_NOT_FOUND);
        }
        //校验密码
        if (md5($params['password']) != $user['password']) {
            throw new UserException(UserErrorCode::USER_CHECK_ERROR);
        }
        //获取token
        $user['token'] = md5($user['id'] . time());
        $user['expiry_time'] = date('Y-m-d H:i;s', time() + env('EXPIRY_TIME'));
        //保存用户信息到redis
        $this->redis->hMSet($user['token'], $user);
        $this->redis->expire($user['token'], (int)env('EXPIRY_TIME'));

        return $user;
    }

    /**
     * 根据手机号码获取用户信息
     * @param int $app_id
     * @param string $mobile
     * @return array
     */
    public function findUserByMobile(int $app_id, string $mobile): array
    {
        $params = [
            'app_id' => $app_id,
            'mobile' => $mobile
        ];
        return $this->userMo->findOne($params);
    }

    /**
     * 根据id获取用户信息
     * @param int $app_id
     * @param int $id
     * @return array
     */
    public function findUserById(int $app_id, int $id): array
    {
        $this->userRequest->findUserByIdValidate([
            'app_id' => $app_id,
            'id' => $id
        ]);
        return $this->userMo->findOneById($id);
    }

    /**
     * 获取所有用户
     * @param int $app_id
     * @return array
     */
    public function getUsers(int $app_id)
    {
        return $this->userMo->findAll([
            'app_id' => $app_id,
            'status' => 1
        ]);
    }
}
