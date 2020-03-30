<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/14
 */

namespace App\Service;


use Hyperf\Elasticsearch\ClientBuilderFactory;

class EsService extends BaseService
{
    /**
     * 默认主机
     * @var string
     */
    private $_default_host = 'http://127.0.0.1:9200';

    /**
     * 创建客户端
     * @return \Elasticsearch\Client
     */
    public function client(): \Elasticsearch\Client
    {
        $host = env('ES_HOST', $this->_default_host);
        // 如果在协程环境下创建，则会自动使用协程版的 Handler，非协程环境下无改变
        $builder = make(ClientBuilderFactory::class)->create();
        return $builder->setHosts([$host])->build();
    }

    /**
     * 客户端信息
     */
    public function info()
    {
        return $this->client()->info();
    }
}
