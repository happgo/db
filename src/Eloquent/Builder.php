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

    public function where($column, $value)
    {








    }

    public function create($value)
    {

    }

    public function update($value)
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

    public function buildSql()
    {




    }

}