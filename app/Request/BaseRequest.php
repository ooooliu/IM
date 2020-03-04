<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/2/28
 */

namespace App\Request;


use Hyperf\Contract\ValidatorInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Validation\ValidationException;
use Hyperf\Validation\ValidatorFactory;

class BaseRequest
{
    /**
     * @Inject()
     * @var ValidatorFactory
     */
    protected $validationFactory;

    public function error(ValidatorInterface $validator)
    {
        throw new ValidationException($validator);
    }
}