<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/2/28
 */

namespace App\Request;


use App\Constants\UserErrorCode;
use App\Exception\UserException;

class UserRequest extends BaseRequest
{
    //用户昵称验证规则
    protected $nickname = 'bail|required|max:64';

    //用户密码验证规则
    protected $password = 'bail|required|max:24';

    /**
     * 用户注册验证
     * @param array $params
     */
    public function addUserValidate(array $params): void
    {
        $validator = $this->validationFactory->make($params, [
            'mobile' => $this->mobile,
            'nickname' => $this->nickname,
            'password' => $this->password,
            'app_id' => $this->app_id,
        ]);

        if ($validator->fails()) {
            throw new UserException(UserErrorCode::USER_PARAMS_ERROR, $validator->errors()->first());
        }
    }

    /**
     * 用户登录验证
     * @param array $params
     */
    public function signInValidate(array $params): void
    {
        $validator = $this->validationFactory->make($params, [
            'mobile' => $this->mobile,
            'password' => $this->password,
            'app_id' => $this->app_id,
        ]);

        if ($validator->fails()) {
            throw new UserException(UserErrorCode::USER_PARAMS_ERROR, $validator->errors()->first());
        }
    }

    /**
     * 根据用户id获取用户信息验证
     * @param array $params
     */
    public function findUserByIdValidate(array $params): void
    {
        $validator = $this->validationFactory->make($params, [
            'id' => $this->id
        ]);

        if ($validator->fails()) {
            throw new UserException(UserErrorCode::USER_PARAMS_ERROR, $validator->errors()->first());
        }
    }
}
