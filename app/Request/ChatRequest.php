<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/12
 */

namespace App\Request;


use App\Constants\ChatErrorCode;
use App\Exception\ChatException;

class ChatRequest extends BaseRequest
{
    /**
     * 创建聊天室验证
     * @param array $params
     */
    public function addChatValidate(array $params): void
    {
        $validator = $this->validationFactory->make($params, [
            'to_id' => $this->id
        ]);

        if ($validator->fails()) {
            throw new ChatException(ChatErrorCode::PARAMS_ERROR, $validator->errors()->first());
        }
    }

    /**
     *
     * @param int $from_id
     * @param int $to_id
     */
    public function findChatValidate(int $from_id, int $to_id): void
    {
        $validator = $this->validationFactory->make([
            'from_id' => $from_id,
            'to_id' => $to_id,
        ], [
            'from_id' => $this->id,
            'to_id' => $this->id,
        ]);

        if ($validator->fails()) {
            throw new ChatException(ChatErrorCode::PARAMS_ERROR, $validator->errors()->first());
        }
    }
}
