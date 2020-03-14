<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/12
 */

namespace App\Request;


use App\Constants\MessageErrorCode;
use App\Exception\RecordException;

class RecordRequest extends BaseRequest
{
    //消息验证规则
    protected $msg = 'bail|required|min:1';

    /**
     * 发送消息参数验证
     * @param array $params
     */
    public function sendMessageValidate(array $params): void
    {
        $validator = $this->validationFactory->make($params, [
            'chat_id' => $this->id,
            'msg' => $this->msg
        ]);

        if ($validator->fails()) {
            throw new RecordException(MessageErrorCode::MESSAGE_PARAMS_ERROR, $validator->errors()->first());
        }
    }
}
