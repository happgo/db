<?php
/**
 * Created by IntelliJ IDEA
 * Author: 张伯发
 * Date  : 2019/9/18
 * Time  : 22:08
 */

namespace Happgo\Db;


class Db
{

    private static $instance;

    private function __construct()
    {
    }

    public static function init() : self
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }


    }


}