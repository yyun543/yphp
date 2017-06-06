<?php
/**
 * 示例控制器
 */
namespace app\controllers;

use yphp\view;
use app\models;
class indexController extends \yphp
{
    use view;
    /*
    * index方法
    */
    public function index()
    {
    	// 实例化模型
    	$model = M('users');
    	$user_arr = $model->getAllUsers();
    	// P($user_arr);
    	$conf['WEBTITLE']='欢迎使用YPHP';
        $conf['DESC']='YPHP是一个轻量级的现代化PHP开发框架';
        // 设置模板变量
    	$this->assign('conf',$conf);
        // 渲染模板
        $this->display('index/index.html');
    }
    /*
    * hello方法
    */
    public function hello(){
        P('Hello YPHP!');
        \yphp\session::set('name','Hello BugLi');
        P(\yphp\session::get('name'));
    }

    /*
    *测试依赖注入
     */
    public function didemo(){
/*        
        TODO
        // 获得容器
        $app = new \yphp\lib\DI\Container();
        // 向容器中绑定组件
        $app->bind('a', '\app\controllers\A');
        $app->bind('b', '\app\controllers\B');
        $app->bind('c', '\app\controllers\C');
        // 单例绑定
        // $app->bindSingle('sa', '\app\controllers\A');
        // 从容器中取出对象
        $b = $app->make('b');
        $b->say();*/
    }

}

