<?php
/**
 * 示例模型
 */
namespace app\models;
use yphp\model;

class usersModel
{
    public function getAllUsers()
    {
    	// 实例化模型
    	$model = new model();
    	$data = $model->select('users','*');
    	return $data;
    }
}