<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/2/28
 */

namespace App\Constants;


use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class BaseErrorCode extends AbstractConstants
{
    /**
     * @Message("Server Error！")
     */
    const SERVER_ERROR = 500;

    /**
     * @Message("Model Not Found！")
     */
    const NOT_FOUND = 404;

    /**
     * @Message("DB Create Error！")
     */
    const DB_CREATE_FAILED = 800;

    /**
     * @Message("DB Create Error！")
     */
    const DB_UPDATE_FAILED = 801;

    /**
     * @Message("DB DELETE Error！")
     */
    const DB_DELETE_FAILED = 802;
}