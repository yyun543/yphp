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
        $argv = $_SERVER['argv'];
        unset($argv[0]);
        $shellName = array_shift($argv);
        $shellName = empty($shellName) ? 'help' : $shellName;

        //加载脚本
        $shellFile = "common\\shell\\{$shellName}";
        try {
            $f_name = str_replace('\\', DS, trim(ROOT_DIR.DS.$shellFile.'.php', '\\'));
            if(file_exists($f_name)) {
                require_once $f_name;
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