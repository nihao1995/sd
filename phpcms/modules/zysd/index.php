<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_func('global');
pc_base::load_app_class('foreground');

class index{
	function __construct() {
		$this->_userid = param::get_cookie('_userid');
	}

	/**
	 * 收藏列表
	 */
	public function collect()
	{
		$_userid = $this->_userid;
		include template('zymember', 'collect');
	}

}
?>
