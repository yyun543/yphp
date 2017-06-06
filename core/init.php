<?php
/* ========================================================================
 * 框架加载文件，用于引导框架启动
 * ======================================================================== */
define('TIME', $_SERVER['REQUEST_TIME']);
define('YPHP_VERSION','1.6.1');
// 调试模式
defined('DEBUG') or define('DEBUG', true);
// 根目录
defined('ROOT_DIR') or define('ROOT_DIR', realpath(__DIR__.'/../'));
// 定义目录分隔符
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
//系统路径
defined('CORE') or define('CORE', ROOT_DIR .DS.'core'.DS);
// 框架核心类库目录
defined('YPHP_DIR') or define('YPHP_DIR',CORE.'yphp'.DS);
// 模块目录
defined('MODULE') or define('MODULE', 'app');
// 应用目录
defined('APP') or define('APP', ROOT_DIR . DS . MODULE . DS);
if(DEBUG && PHP_SAPI != 'cli') {
    //打开PHP的错误显示
    ini_set('display_errors',true);
    //载入友好的错误显示类
    $whoops = new \Whoops\Run;
    $errorPage = new \Whoops\Handler\PrettyPageHandler;
    $errorPage->setPageTitle("YPHP出大事啦!!!");
    $whoops->pushHandler($errorPage);
    $whoops->register();
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 'Off');
    ini_set('log_errors', 'On');
    ini_set('error_log', ROOT_DIR.DS.'runtime'.DS.'log'.DS.'error.log');
}
//加载公用函数
require_once CORE .'function/function.php';
//加载框架内核
require_once CORE . 'yphp.php';

//注册自动加载
spl_autoload_register('\yphp::load');
//设置默认时区
date_default_timezone_set(\yphp\conf::get('TIMEZONE','system'));
// 判断是否是命令行模式
if(PHP_SAPI == 'cli') {
    \yphp_cli::run();
} else {
    //开始跑框架
    \yphp::run();
}
