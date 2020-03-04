<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;

/**
 * index
 */
Router::addGroup('/', function () {
    Router::addRoute(['GET', 'POST', 'HEAD'], '', 'App\Controller\IndexController@index');
    Router::addRoute(['GET', 'POST', 'HEAD'], 'websocket', 'App\Controller\IndexController@websocket');
});

/**
 * Websocket Server
 */
Router::addServer('ws', function () {
    Router::get('/', 'App\Controller\WebSocketController');
});

/**
 * User
 */
Router::addGroup('/user/', function () {
    Router::post('register', 'App\Controller\UserController@register');
    Router::post('login', 'App\Controller\UserController@login');
    Router::post('auto_register', 'App\Controller\UserController@autoRegister');
});

Router::addGroup('', function () {
    /**
     * User
     */
    Router::addGroup('/user/', function () {
        Router::post('login_out', 'App\Controller\UserController@loginOut');
        Router::get('find_user', 'App\Controller\UserController@findUserById');
    });
    /**
     * Chat
     */
    Router::addGroup('/chat/', function () {
        Router::post('send_msg', 'App\Controller\ChatController@sendMessage');
    });
}, ['middleware' => [App\Middleware\AuthMiddleware::class]]);
