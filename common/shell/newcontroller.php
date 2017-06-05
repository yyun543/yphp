<?php
namespace common\shell;

use common\baseCommon;
use yphp\cliHelp;

class newcontroller extends baseCommon
{
    public $param;

    public function __construct($param)
    {
        $this->param = $param;
        parent::__construct();
    }

    public function start()
    {
        if(isset($this->param[0])) {
            $fileName = $this->param[0];
            $filePath = ROOT_DIR.'/'.MODULE.'/controllers/'.$fileName .'Controller.php';
            if(file_exists($filePath)) {
                throw New \Exception('已存在的控制器'.$fileName);
            } else {
                $cliHelp = new cliHelp();
                if(file_put_contents($filePath,$cliHelp->newController($fileName))) {
                    p('创建成功');
                } else {
                    p('创建失败');
                }
            }
        } else {
            throw New \Exception('缺少参数');
        }
        $this->goodbye();
    }
}