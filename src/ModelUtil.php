<?php
/**
 * Created by IntelliJ IDEA
 * Author: 张伯发
 * Date  : 2019/9/20
 * Time  : 17:11
 */

namespace Happgo\Db;


class ModelUtil
{

    public static function getClassName(string $proxyClassName): string
    {
        list($className) = explode('_', $proxyClassName);
        return $className;
    }

}