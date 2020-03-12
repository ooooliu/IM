<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/3
 */

namespace App\Controller;


use App\Service\ChatService;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

class ChatController extends BaseController
{
    /**
     * @Inject()
     * @var ChatService
     */
    protected $chatService;

    /**
     *
     * @return array|string
     */
    public function addChat()
    {
        try {
            return $this->chatService->addChat($this->request->all());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
