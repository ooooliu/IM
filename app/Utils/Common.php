<?php
/**
 * Created by PhpStorm2019.
 * @copyright: 杭州云呼网络科技有限公司
 * @author:    Lyn
 * @date:      2020/3/3
 */

namespace App\Utils;


class Common
{
    /**
     * 随机创建手机号码
     * @return string
     */
    public function getRandMobile(): string
    {
        $tel_arr = ['130','131','132','133','134','135','136','137','138','139','144','147','150','151','152','153','155','156','157','158','159','176','177','178','180','181','182','183','184','185','186','187','188','189'];

        return $tel_arr[array_rand($tel_arr)].mt_rand(1000,9999).mt_rand(1000,9999);
    }

    /**
     * 获取随机字符串
     * @param int $length
     * @return string
     */
    public function getRandChar(int $length): string
    {
        $str = '';
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str .= $strPol[mt_rand(0, $max)];
        }
        return $str;
    }
}