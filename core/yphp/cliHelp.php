<?php
/*
*帮助类
*/
namespace yphp;

class cliHelp
{
    public function newController($file)
    {
        return "<?php
namespace ".MODULE."\\controllers;

class ".$file."Controller extends \\yphp
{
    public function index()
    {
        //put some
    }
}
";
    }

    public function newModel($file)
    {
        return "<?php
namespace ".MODULE."\\models;

use yphp\model;
class ".$file."Model
{
    public function index()
    {
        //put some
    }
}
";
    }


}