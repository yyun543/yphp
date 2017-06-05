<?php
/* ========================================================================
 * YPHP入口文件，用于定义常量
 * ======================================================================== */
//如果是多模块,可以通过动态设置module的形式,动态条用不同模块
if ($_SERVER['SERVER_NAME'] == 'manage.taovq.com' || $_SERVER['SERVER_NAME'] == 'admin.taovq.com') {
    $MODULE_NAME = 'admin';
} else {
    $MODULE_NAME = 'app';
}
// 调试模式
define('DEBUG', true);
// 根目录
define('ROOT_DIR', realpath(__DIR__.'/../'));
// 定义目录分隔符
define('DS', DIRECTORY_SEPARATOR);
//系统路径
define('CORE', ROOT_DIR .DS.'core'.DS);
// 模块目录
define('MODULE', $MODULE_NAME);
// 应用目录
define('APP', ROOT_DIR . DS . $MODULE_NAME . DS);

//载入composer
require_once ROOT_DIR.DS.'vendor'.DS.'autoload.php';