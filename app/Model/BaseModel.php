<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/2/28
 */

namespace App\Model;


class BaseModel extends Model
{
    /**
     * Base Add One
     * @param array $params
     * @return array
     */
    public function addOne(array $params): array
    {
        $model = self::query()
            ->create($params);
        return $model->toArray();
    }

    /**
     * Base Update One By Where
     * @param array $where
     * @param array $values
     * @return int
     */
    public function updateOne(array $where, array $values)
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
    public function deleteOne(array $where)
    {
        return self::query()
            ->where($where)
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
            ->where($params)
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
            $model->where($params);
        }
        return $model->get($columns)->toArray();
    }

    /**
     * Base Find One By Id
     * @param int $id
     * @param array $columns
     * @return array
     */
    public function findOneById(int $id, array $columns = ['*'])
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
    public function findPaginate(array $params = [], array $columns = ['*'], int $perPage = 20, int $page = 1)
    {
        $model = self::query();
        if (!empty($params)) {
            $model->where($params);
        }
        return $model->paginate($perPage, $columns, 'page', $page)
            ->toArray();
    }


}