<?php
namespace yphp\lib\Redis;
/**
 * redis 驱动类
 * @author BugLi <263273742@qq.com>
 * @content 本类使用了魔法函数重载，可调用 php_redis 扩展内的所有函数。
 *静态调用
 * $conf = [
 *     'host'     => '127.0.0.1',
 *     'port'     => 6379,
 *     'password' => '',
 *     'database' => 2,
 * ];
 * yphp\lib\Redis\Redis::config($conf);
 * var_dump(yphp\lib\Redis\Redis::hGetAll('user:1'));
 * 动态调用
 * $conf = [
 *     'host'     => '127.0.0.1',
 *     'port'     => 6379,
 *     'password' => '',
 *     'database' => 2,
 * ];
 * $redis = new yphp\lib\Redis\Redis;
 * $redis->config($conf);
 * var_dump($redis->hGetAll('user:1'));
 * 
 */
class Redis
{
    // redis对象
    private static $redis;
    // 配置信息
    private static $config;
    // 构造
    public function __construct($params = [])
    {
        empty($params) or self::config($params);
    }
    // 配置
    public static function config($params)
    {
        self::$config = $params;
    }
    // 连接redis服务器
    public static function connect()
    {
        if (!isset(self::$redis)) {
            $redis = new \Redis();
            // connect 这里如果设置timeout，是全局有效的，执行brPop时会受影响
            if (!$redis->connect(self::$config['host'], self::$config['port'])) {
                throw new \Exception('Redis Connect Failure', 1);
            }
            $redis->auth(self::$config['password']);
            $redis->select(self::$config['database']);
            self::$redis = $redis;
        }
        return self::$redis;
    }
    public function __call($name, $arguments)
    {
        $redis = self::connect();
        return call_user_func_array([$redis, $name], $arguments);
    }
    public static function __callStatic($name, $arguments)
    {
        $redis = self::connect();
        return call_user_func_array([$redis, $name], $arguments);
    }
}
