<?php
/**
 * Created by IntelliJ IDEA
 * Author: 张伯发
 * Date  : 2019/9/18
 * Time  : 22:09
 */

namespace Happgo\Db;

use Chan;
use Swoole\Coroutine\MySQL;

/**
 * 连接池
 * Class DbPool
 * @author 张伯发 2019/9/19 17:42
 */
class DbPool
{



    /**
     * @var Chan
     */
    private $pool;

    /**
     * @var DbPool
     */
    private static $instance;


    private $config = [
        'max_num' => 100,
        'mysql' => [
            'host'          => '127.0.0.1',
            'port'          => 3306,
            'user'          => 'root',
            'password'      => 'root',
            'database'      => 'happgo',
            'timeout'       => '3000', //建立连接超时时间
        ]
    ];

    private function __construct()
    {
    }

    /**
     * @return DbPool
     * @author 张伯发 2019/9/19 17:40
     */
    public static function getInstance(): DbPool
    {
        if (self::$instance == null) {
            $dbPool = new DbPool();
            $dbPool->init();
            self::$instance = $dbPool;
        }
        return self::$instance;
    }

    private function init()
    {
        $this->pool = new Chan($this->config["max_num"]);//用channel来作为连接池容器
        for ($i = 0; $i < $this->config["max_num"]; $i++) {
            $mysql = new MySQL();
            $res = $mysql->connect($this->config['mysql']);
            if ($res == false) {
                throw new \RuntimeException("failed to connect mysql server");
            }
            $this->release($mysql);
        }
    }

    /**
     * @des 获取链接
     */
    public function get(): MySQL
    {
        return $this->pool->pop();
    }

    /**
     * @param $mysql
     * @des 回收链接
     */
    public function release($mysql)
    {
        $this->pool->push($mysql);
    }





    // TODO 断线重连



}