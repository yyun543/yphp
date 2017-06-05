<?php
/*
* 依赖注入容器
* @Auther:BugLi QQ:263273742
* @Date:2017-06-06
* @Version:1.0.0
*
* 使用说明：
* 获得容器
* $app = new yphp\lib\DI\Container();
* 向容器中绑定组件
* $app->bind('组件标识', '类名称|类实例');
* 单例绑定
* $app->bindSingle('组件标识', '类名称|类实例');
* 从容器中取出对象
* $app->make('标识名称',[参数]);
*/
namespace yphp\lib\DI;

class Container
{
    /**
     * 储存绑定的类
     *
     * @var array
     */
    private $binds = [];
    /**
     * 储存绑定的实例
     *
     * @var array
     */
    private $instances = [];
    /**
     * 单例标记
     *
     * @var array
     */
    private $singles = [];
    /**
     * 绑定到容器
     *
     * @param $key
     * @param $value
     */
    public function bind($key, $value)
    {
        $this->register($key, $value);
    }
    /**
     * 绑定到容器为单例
     *
     * @param $key
     * @param $value
     */
    public function bindSingle($key, $value)
    {
        $this->register($key, $value, true);
    }
    /**
     * 从容器中取出实例
     *
     * @param $key
     * @param $params
     */
    public function make($key, $params = [])
    {
        //如果在实例中保存有,直接返回
        if (! empty($this->instances[$key])) {
            //如果是单例
            if (in_array($key, $this->singles)) {
                return $this->instances[$key];
            }
            //如果不是单例
            return clone $this->instances[$key];
        }
        //如果绑定有类名,获取实例并保存到instances
        if (! empty($this->binds[$key])) {
            $this->instances[$key] = $this->getNewInstance($key, $params);
            return $this->instances[$key];
        }
        return null;
    }
    /**
     * 将bings里的类实例化
     *
     * @param $key
     * @param array $args
     * @return object
     * @throws \ReflectionException
     */
    private function getNewInstance($key, $args = [])
    {
        //获得完整类名
        $className = $this->binds[$key];
        //反射
        try {
            $reflectClass = new \ReflectionClass($className);
        } catch (\ReflectionException $e) {
            throw new \ReflectionException(sprintf('Class "%s" does not exist', $className));
        }
        //如果有构造方法
        if ($constructor = $reflectClass->getConstructor()) {
            //如果构造方法中有参数
            if ($params = $constructor->getParameters()) {
                //遍历构造方法参数
                $objParams = [];
                foreach ($params as $key => $param) {
                    //如果参数是对象
                    if ($interface = $param->getClass()) {
                        //从容器中取出所依赖的对象
                        $objParams[] = $this->useClassNameGetInstance($interface->name);
                    }
                }
            }
            // 注入对象
            if (!empty($objParams)) {
                return $reflectClass->newInstanceArgs(array_merge($objParams, $args));
            }
        }
        //没有构造方法
        if (empty($args)) {
            return $reflectClass->newInstance();
        }
        return $reflectClass->newInstanceArgs($args);
    }
    /**
     * 注册class到容器
     *
     * @param $key
     * @param $value
     * @param bool $single
     */
    private function register($key, $value, $single = false)
    {
        //记录单例
        if ($single) {
            $this->singles[] = $key;
        }
        //如果是对象存入instances
        if (is_object($value)) {
            $this->instances[$key] = $value;
            //将类名保存到binds
            $this->binds[$key] = get_class($value);
        }
        //如果是类名存入binds
        if (is_string($value)) {
            $this->binds[$key] = $value;
        }
    }
    /**
     * 根据类全名获得实例
     *
     * @param $className
     * @return mixed|null
     * @throws \Exception
     */
    private function useClassNameGetInstance($className)
    {
        $trans = array_flip($this->binds);
        if (!empty($trans[$className])) {
            return $this->make($trans[$className]);
        } else {
            throw new \Exception(sprintf('Class "%s" does not exist', $className));
        }
    }
}