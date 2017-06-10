<?php
/**
 * session 操作类
 * @author BugLi  2017-05-26
 */
namespace yphp;

class session
{
	/*
	 * 开启session
	 */
	public static function register(){
		$start_flg = session_start();
		ini_set("session.cookie_httponly", true);
		if(!$start_flg){
			throw new Exception('SESSION开启失败，请检查是否已启用SESSION扩展！');
		}
	}
	public static function set($sessionName,$value)
	{
		return $_SESSION[$sessionName] = $value;
	}

	/**
	 * 根据sessionName获取session值
	 * @param string $sessionName
	 * @return string session的值如果没有此session，返回空。
	 */
	public static function get($sessionName)
	{
		return isset($_SESSION[$sessionName]) ? $_SESSION[$sessionName] : '';
	}

	/**
	 * 删除一个session
	 * @param string $sessionName
	 */
	public static function del($sessionName)
	{
		if(isset($sessionName))
		{
		unset($_SESSION[$sessionName]);
		return TRUE;
		}
		return False;
	}

	public static function clear()
	{
		if(isset($_SESSION))
		{
			session_unset();
		}
	}
}