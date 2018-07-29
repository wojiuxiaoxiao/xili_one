<?php
class Load
{
	function functions($name)
	{
		return include_once(ROOT_PATH . VERSION. '/include/function/' .$name.'.func.php');
	}
	function logic($name)
	{
		return include_once(ROOT_PATH . VERSION. 'include/logic/' .$name.'.logic.php');
	}
	function lib($name)
	{
		return include_once(ROOT_PATH .VERSION. 'include/lib/' .$name.'.php');
	}
}


class Obj
{
	function &Obj($name=null)
	{
		Return Obj::_share($name,$null,'get');
	}

	function &_share($name=null,&$mixed,$type='set')
	{
		static $_register=array();
		if($name==null)
		{
			Return $_register;
		}
		if(isset($_register[$name]) and $type==='get')
		{
			Return $_register[$name];
		}
		elseif($type==='set')
		{
			$_register[$name]=&$mixed;
		}

		return true;
	}

	function register($name,&$obj)
	{
		Obj::_share($name,$obj,"set");
	}

	function &registry($name=null)
	{
		Return Obj::_share($name,$null,'get');
	}

	function isRegistered($name)
	{
		Return isset($_register[$name]);
	}
}