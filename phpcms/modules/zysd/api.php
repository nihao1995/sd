<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_func('global');

class api{
	function __construct() {
	}

	public function test(){
		returnAjaxData(1);
	}
	public function set(){
		$cookie = param::set_app_cookie("_userid", 1);
		echo($cookie);
	}
	public function get(){
		$cookie = param::get_app_cookie("_userid", $_GET["type"]);
		echo($cookie);
	}
}
?>
