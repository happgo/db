<?php
/**
 * Created by IntelliJ IDEA
 * Author: 张伯发
 * Date  : 2019/9/20
 * Time  : 11:40
 */

namespace Happgo\Db\Eloquent;

use Happgo\Db\DbPool;

class Builder
{
    protected $query;

    protected $model;

    protected $from;

    /**
     * @var array
     */
    protected $where = [];

    /**
     * @var array
     */
    protected $fields = [];

    public function __construct()
    {
        $this->query = DbPool::getInstance()->get();
    }

    public function setModel(Model $model): self
    {
        $this->model = $model;
        $this->from = $this->model->getTable();
        var_dump($this->from);
        return $this;
    }

    public function find($id)
    {
        $sql = "select * from {$this->from} where id = ?";
        return $this->execute($sql, [$id]);
    }

    public function select()
    {

    }

    public function where()
    {

    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function execute(string $sql, array $params) : array
    {
        $stmt = $this->query->prepare($sql);
        if ($stmt == false) {
            var_dump($this->query->errno, $this->query->error);
        }
        $res = [];
        try {
            $res = $stmt->execute($params);//绑定参数 执行sql
        } catch (\Exception $e) {
            //
        }

        // 释放mysql连接
        DbPool::getInstance()->release($this->query);
        return $res;
    }



    public function sayHello($hello)
    {
        var_dump($hello);

    }

    public function test($msg)
    {
        var_dump('static ... ' . $msg);

    }

}