<?php

/* ========================================================================
 * yphp核心类
 * 实现以下几个功能
 * 类自动加载
 * 启动框架
 * 引入模型
 * 引入视图
 * ======================================================================== */

class yphp
{
    /**
     * model用于存放已经加载的model模型,下次加载时直接返回
     */
    public $model;
    /**
     * 视图赋值
     */
    public $assign;


    /**
     * 自动加载类
     * @param string $class 需要加载的类,需要带上命名空间
     */
    public static function load($class)
    {
        $class = str_replace('\\', '/', trim($class, '\\'));
        if (is_file(CORE . $class . '.php')) {
            require_once CORE . $class . '.php';
        } else if(is_file(YPHP_DIR . $class . '.php')){
            require_once YPHP_DIR  . $class . '.php';
        } else if(is_file(APP . $class . '.php')){
            require_once APP  . $class . '.php';
        }
    }

    /**
     * 框架启动方法,完成了两件事情
     * 1.加载route解析当前URL
     * 2.找到对应的控制以及方法,并运行
     */
    public static function run()
    {
        //路由初始化
        $request = new \yphp\route();
        //注册session
        \yphp\session::register();
        //注册日志处理模块
        \yphp\log::init();
        $controllerClass = '\\' . MODULE . '\controllers\\' . $request->controller . 'Controller';
        $action = $request->action;
        $controllerFile = APP . 'controllers/' . $request->controller . 'Controller.php';

        if (is_file($controllerFile)) {
            require_once $controllerFile;
        } else {
            if (DEBUG) {
                throw new Exception($controllerClass . '是一个不存在的控制器');
            } else {
                error404();
            }
        }
        $controller = new $controllerClass();
        //如果开启restful,那么加载方法时带上请求类型
        if (\yphp\conf::get('OPEN_RESTFUL', 'system')) {
            $action = strtolower($request->method()) . ucfirst($action);
        }
        $controller->$action();
    }

}