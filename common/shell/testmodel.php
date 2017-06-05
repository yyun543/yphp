<?php
namespace common\shell;

use common\baseCommon;
use yphp\model;

class testmodel extends baseCommon
{
    public $param;

    public function __construct($param)
    {
        $this->param = $param;
        parent::__construct();
    }

    public function start()
    {
        $model = new model();

        dump($model->info());

        $this->goodbye();
    }
}