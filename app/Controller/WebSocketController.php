<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/2/27
 */

namespace App\Controller;


use App\Service\WebSocketService;
use Hyperf\Contract\OnCloseInterface;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Swoole\Http\Request;
use Swoole\Server;
use Swoole\Websocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;

/**
 * Websocket Server
 * Class WebSocketController
 * @package App\Controller
 */
class WebSocketController implements OnMessageInterface, OnOpenInterface, OnCloseInterface
{
    /**
     * @Inject()
     * @var \Redis
     */
    protected $redis;

    /**
     * @Inject()
     * @var RequestInterface
     */
    protected $request;

    /**
     * @Inject()
     * @var WebSocketService
     */
    protected $socket;

    /**
     * 消息接收绑定事件
     * @param WebSocketServer $server
     * @param Frame $frame
     */
    public function onMessage($server, Frame $frame): void
    {
        var_dump($frame);
        $this->socket->onMessageDemo($frame);
    }

    /**
     * 断开websocket连接绑定事件
     * @param Server $server
     * @param int $fd
     * @param int $reactorId
     */
    public function onClose($server, int $fd, int $reactorId): void
    {
        var_dump('closed');
        //注销用户
        $this->socket->onClose($fd);
    }

    /**
     * 连接绑定事件
     * @param WebSocketServer $server
     * @param Request $request
     */
    public function onOpen($server, Request $request): void
    {
        $this->socket->onOpen($request);
    }
}
