<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/10
 */

namespace App\Model;


use Hyperf\Database\Model\SoftDeletes;
use Hyperf\ModelCache\Cacheable;
use Hyperf\ModelCache\CacheableInterface;
use Hyperf\Snowflake\IdGenerator\SnowflakeIdGenerator;

class MongoModel extends \Jmhc\Mongodb\Eloquent\Model implements CacheableInterface
{
    use Cacheable;
    use SoftDeletes;

    /**
     * mongo定义类型字段,进行类型转换
     * @var array
     */
    protected $mongoFields = [];

    /**
     * 获取id
     * @return int
     */
    private function _getId(): int
    {
        $snowflake = make(SnowflakeIdGenerator::class);
        return $snowflake->generate();
    }

    /**
     * 字段强转类型
     * @param array $params
     * @return array
     */
    private function _typeForMongo(array $params): array
    {
        if (empty($this->mongoFields))
            return $params;

        $data = [];
        foreach ($params as $key => $value) {
            if (!isset($this->mongoFields[$key]))
                continue;

            switch ($this->mongoFields[$key]) {
                case 'int' :
                    $data[$key] = (int)$value;
                    break;
                default :
                    $data[$key] = (string)$value;
                    break;
            }
        }
        return $data;
    }

    /**
     * 自定义ID
     * Model constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        if ($attributes && !isset($attributes['id'])) {
            $attributes['id'] = $this->_getId();
        }
        parent::__construct($this->_typeForMongo($attributes));
    }

    /**
     * Base Add One
     * @param array $params
     * @return array
     */
    public function addOne(array $params): array
    {
        if ($params && !isset($params['id'])) {
            $params['id'] = $this->_getId();
        }

        $model = self::query()
            ->create($this->_typeForMongo($params));
        return $model->toArray();
    }

    /**
     * Base Update One By Where
     * @param array $where
     * @param array $values
     * @return int
     */
    public function updateOne(array $where, array $values): int
    {
        return self::query()
            ->where($this->_typeForMongo($where))
            ->update($this->_typeForMongo($values));
    }

    /**
     * Base Delete One By Where
     * @param array $where
     * @return int|mixed
     */
    public function deleteOne(array $where): int
    {
        return self::query()
            ->where($this->_typeForMongo($where))
            ->delete();
    }

    /**
     * Base Find One
     * @param array $params
     * @param array $columns
     * @return array
     */
    public function findOne(array $params, array $columns = ['*']): array
    {
        $model = self::query()
            ->where($this->_typeForMongo($params))
            ->first($columns);

        return $model ? $model->toArray() : [];
    }

    /**
     * Base Find All
     * @param array $params
     * @param array $columns
     * @return array
     */
    public function findAll(array $params = [], array $columns = ['*']): array
    {
        $model = self::query();
        if (!empty($params)) {
            $model->where($this->_typeForMongo($params));
        }
        return $model->get($columns)->toArray();
    }

    /**
     * Base Find One By Id
     * @param int $id
     * @param array $columns
     * @return array
     */
    public function findOneById(int $id, array $columns = ['*']): array
    {
        $model = self::query()
            ->find($id, $columns);
        return $model ? $model->toArray() : [];
    }

    /**
     * Base Find Paginate
     * @param array $params
     * @param array $columns
     * @param int $perPage
     * @param int $page
     * @return mixed
     */
    public function findPaginate(array $params = [], array $columns = ['*'], int $perPage = 20, int $page = 1): array
    {
        $model = self::query();
        if (!empty($params)) {
            $model->where($this->_typeForMongo($params));
        }
        return $model->paginate($perPage, $columns, 'page', $page)
            ->toArray();
    }
}
