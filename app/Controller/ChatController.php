<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/3
 */

namespace App\Controller;


use App\Service\ChatService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

class ChatController extends BaseController
{
    /**
     * @Inject()
     * @var ChatService
     */
    protected $chatService;


}
