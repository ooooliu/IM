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

namespace App\Model;


use Hyperf\DbConnection\Model\Model as BaseModel;
use Hyperf\ModelCache\Cacheable;
use Hyperf\ModelCache\CacheableInterface;
use Hyperf\Snowflake\IdGenerator\SnowflakeIdGenerator;

class Model extends BaseModel implements CacheableInterface
{
    use Cacheable;

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
     * 自定义ID
     * Model constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        if ($attributes && !isset($attributes['id'])) {
            $attributes['id'] = $this->_getId();
        }
        parent::__construct($attributes);
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
            ->create($params);
        return $model->toArray();
    }

    /**
     *
     * @param array $params
     * @return bool
     */
    public function addAll(array $params): bool
    {
        foreach ($params as $key => $value) {
            if (!is_array($value))
                continue;

            if (!isset($value['id'])) {
                $params[$key]['id'] = $this->_getId();
            }
        }
        return self::query()->insert($params);
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
            ->where($where)
            ->update($values);
    }

    /**
     * Base Delete One By Where
     * @param array $where
     * @return int|mixed
     */
    public function deleteOne(array $where): int
    {
        return self::query()
            ->where($where)
            ->delete();
    }

    /**
     * Base Find One
     * @param array $where
     * @param array $columns
     * @return array
     */
    public function findOne(array $where, array $columns = ['*']): array
    {
        $model = self::query()
            ->where($where)
            ->first($columns);

        return $model ? $model->toArray() : [];
    }

    /**
     * Base Find All
     * @param array $where
     * @param array $columns
     * @return array
     */
    public function findAll(array $where = [], array $columns = ['*']): array
    {
        $model = self::query();
        if (!empty($where)) {
            $model->where($where);
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
     * @param array $where
     * @param array $columns
     * @param int $perPage
     * @param int $page
     * @return mixed
     */
    public function findPaginate(array $where = [], array $columns = ['*'], int $perPage = 20, int $page = 1): array
    {
        $model = self::query();
        if (!empty($where)) {
            $model->where($where);
        }
        return $model->paginate($perPage, $columns, 'page', $page)
            ->toArray();
    }
}
