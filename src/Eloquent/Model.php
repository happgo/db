<?php
/**
 * Created by IntelliJ IDEA
 * Author: 张伯发
 * Date  : 2019/9/20
 * Time  : 11:30
 */

namespace Happgo\Db\Eloquent;

use Happgo\Db\ModelUtil;
use Happgo\Lib\PhpHelper;

/**
 * Class Model
 * @method static Builder find(int $id)
 * @author 张伯发 2019/9/20 11:32
 */
class Model
{
    public function __call($method, $parameters)
    {
        return PhpHelper::call([$this->newModelQuery(), $method], ...$parameters);
    }

    // 这里静态方法调用会触发，然后创建子类时调用对应的方法，如果方法不存在，触发 __call方法，调用Builder中的方法
    public static function __callStatic($method, $parameters)
    {
        return (new static())->$method(...$parameters);
    }

    public function newModelQuery()
    {
        return (new Builder())->setModel($this);
    }

    public function getTable()
    {
        // TODO 获取className, 通过bean获取注解的数据
        $table = strtolower($this->getPrefix(). basename(str_replace('\\', '/', $this->getClassName())));
        return $table;
    }

    protected function getClassName(): string
    {
        return ModelUtil::getClassName(static::class);
    }

    public function getPrefix()
    {
        return 'h_';
    }
}