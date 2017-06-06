<?php

/* ========================================================================
 * yphp cli模式核心类
 * ======================================================================== */

class yphp_cli extends yphp
{
    public static function run()
    {
        //加载日志模块
        \yphp\log::init();
        // 接收命令行参数
        $argv = $_SERVER['argv'];
        unset($argv[0]);
        $shellName = array_shift($argv);
        $shellName = empty($shellName) ? 'help' : $shellName;

        //加载脚本
        $shellFile = "common\\shell\\{$shellName}";
        try {
            $f_name = str_replace('\\', DS, trim(ROOT_DIR.DS.$shellFile.'.php', '\\'));
            // 引入对应命令脚本
            if(file_exists($f_name)) {
                require_once $f_name;
                // 实例化并调用对应脚本处理方法
                $shell = new $shellFile($argv);
                $shell->start();
            } else {
                throw New Exception('不存在的脚本');
            }
        } catch (\Exception $e) {
            p($e->getMessage());
        }
    }
}