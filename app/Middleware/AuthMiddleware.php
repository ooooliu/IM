<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/2
 */

namespace App\Middleware;


use App\Constants\UserErrorCode;
use App\Exception\UserException;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
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
     * @var \Hyperf\HttpServer\Response
     */
    protected $response;

    /**
     * token验证
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $token = $this->request->input('token');
            if ($token) {
                $user_id = $this->redis->hGet($token, 'id');
                if ($user_id > 0) {
                    return $handler->handle($request);
                }
            }
            throw new UserException(UserErrorCode::USER_TOKEN_NOT_PASS);
        } catch (UserException $e) {
            return $this->response->json([
                'code' => $e->getCode(),
                'msg' => $e->getMessage()
            ]);
        }
    }
}