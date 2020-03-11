<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/10
 */

namespace App\Model;


abstract class MongoModel extends \Jmhc\Mongodb\Eloquent\Model
{
    /**
     * mongo定义类型字段,进行类型转换
     * @var array
     */
    protected $mongoFields = [];
}
