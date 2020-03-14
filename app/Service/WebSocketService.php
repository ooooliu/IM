<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/2/27
 */

namespace App\Service;


use App\Constants\MessageErrorCode;
use App\Constants\UserErrorCode;
use App\Exception\MessageException;
use App\Exception\UserException;
use Hyperf\Di\Annotation\Inject;
use Hyperf\WebSocketServer\Server;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;

class WebSocketService extends BaseService
{
    /**
     * @Inject()
     * @var Server
     */
    private $_server;

    /**
     * 获取websocket服务
     * @return WebSocketServer
     */
    private function _getServer(): WebSocketServer
    {
        return $this->_server->getServer();
    }

    /**
     * fd key
     * @return string
     */
    public function fdKey(): string
    {
        return env('FD') ?? 'fd';
    }

    /**
     * user key
     * @return string
     */
    public function fdUserKey(): string
    {
        return env('FD_USER') ?? 'fd_user';
    }

    /**
     * 设置用户fd
     * @param int $fd
     * @param array $user
     * @return bool
     */
    public function setFd(int $fd, array $user): bool
    {
        //记录用户fd
        $fdUserKey = $this->fdUserKey();
        $this->redis->hSet($fdUserKey, $fdUserKey . '_' . $user['id'], $fd);
        //建立fd映射关系
        $fdKey = $this->fdKey();
        $this->redis->hSet($fdKey, $fdKey . '_' . $fd, json_encode($user));
        return true;
    }

    /**
     * 获取用户fd
     * @param int $user_id
     * @return int
     */
    public function getFd(int $user_id): int
    {
        $fdUserKey = $this->fdUserKey();
        return (int)$this->redis->hGet($fdUserKey, $fdUserKey . '_' . $user_id);
    }

    /**
     * 获取用户id
     * @param int $fd
     * @return array
     */
    public function getUser(int $fd): array
    {
        $fdKey = $this->fdKey();
        $res = @json_decode($this->redis->hGet($fdKey, $fdKey . '_' . $fd), true);
        return $res ?? [];
    }

    /**
     * 注销用户fd
     * @param int $user_id
     * @return bool
     */
    public function delFd(int $user_id): bool
    {
        $fdUserKey = $this->fdUserKey();
        $this->redis->hDel($fdUserKey, $fdUserKey . '_' . $user_id);
        return true;
    }

    /**
     * 注销用户fd映射关系
     * @param int $fd
     * @return bool
     */
    public function delUserId(int $fd): bool
    {
        $fdKey = $this->fdKey();
        $this->redis->hDel($fdKey, $fdKey . '_' . $fd);
        return true;
    }

    /**
     * 注销所有用户
     * @return bool
     */
    public function delAll(): bool
    {
        $this->redis->del($this->fdUserKey());
        $this->redis->del($this->fdKey());
        return true;
    }

    /**
     * 定向发送消息
     * @param int $to 接收者
     * @param string $data 消息体数据
     * @return bool
     */
    public function send(int $to, string $data): bool
    {
        $fd = $this->getFd($to);
        //判断用户是否在线
        if ($this->_getServer()->exist($fd)) {
            var_dump($fd);
            $res = $this->_getServer()->push($fd, $data);
        } else {
            //@todo 离线业务
            $res = false;
        }
        return $res;
    }

    /**
     * 发送在线通知
     * @param array $data
     */
    public function notice(array $data): void
    {
        $list = $this->redis->hGetAll($this->fdUserKey());
        if (!empty($list)) {
            foreach ($list as $fd) {
                $this->_getServer()->push($fd, json_encode($data));
            }
        }
    }

    /**
     * onOpen事件,记录连线用户fd
     * @param Request $request
     */
    public function onOpen(Request $request): void
    {
        try {
            $auth = $this->auth();
            if (empty($auth) || empty($auth['id'])) {
                throw new UserException(UserErrorCode::USER_TOKEN_NOT_PASS);
            }

            //记录连线用户fd
            $this->setFd($request->fd, $auth);

            $this->_getServer()->push($request->fd, json_encode([
                'code' => $this->code,
                'type' => 'handShake',
                'msg' => 'Opened',
                'user' => $auth,
                'data' => $request->getData()
            ]));
        } catch (\Exception $e) {
            $this->_getServer()->push($request->fd, json_encode([
                'code' => $e->getCode(),
                'type' => 'handShake',
                'msg' => $e->getMessage()
            ]));
        }
    }

    /**
     * onClose事件,注销用户fd
     * @param int $fd
     */
    public function onClose(int $fd): void
    {
        //获取用户id
        $user = $this->getUser($fd);
        //注销用户fd
        $this->delUserId($fd);
        //注销用户fd
        if (isset($user['id'])) {
            $this->delFd($user['id']);
        }
    }

    /**
     * onMessage测试demo
     * @param Frame $frame
     */
    public function onMessageDemo(Frame $frame): void
    {
        //绑定用户fd
        if (empty($frame->data)) {
            throw new MessageException(MessageErrorCode::RECEIVE_MESSAGE_WRONG);
        }
        $user = json_decode($frame->data, true);
        //保存当前登录的fd
        if ($user['type'] == 'login') {
            //获取所有在线用户列表
            $userArr = make(UserService::class);
            $userList = $userArr->getUsers(200001);
            $data = [];
            foreach ($userList as $value) {
                $fd = $this->getFd($value['id']);
                $data[] = [
                    'username' => $value['nickname'],
                    'headerimg' => $value['head_url'],
                    'login_time' => date('Y-m-d'),
                    'status' => $this->_getServer()->exist($fd) ? '在线' : '离线'
                ];
            }
            var_dump($data);
            $this->notice([
                'type' => $user['type'],
                'msg' => $this->getUser($frame->fd)['nickname'] ?? '',
                'user_list' => $data
            ]);
        } elseif ($user['type'] == 'user') {
            $res = $this->getUser($frame->fd);
            //{"type":"user","from":"user83707085","msg":"nihao","headerimg":"img\/a9.jpg"}
            $this->notice([
                'type' => $user['type'],
                'from' => $res['nickname'] ?? '',
                'msg' => $user['msg'],
                'headerimg' => $res['head_url'] ?? '',
            ]);
        }
    }
}
