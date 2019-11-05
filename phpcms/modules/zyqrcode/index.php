<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_func('global');
pc_base::load_sys_class('form', '', 0);
pc_base::load_sys_class('format', '', 0);
require_once 'classes/phpqrcode/QRcode.class.php';
class index{
	function __construct() {
		$this->get_db = pc_base::load_model('get_model');
		$this->qrcode_db = pc_base::load_model('zyqrcode_model');
		$this->fx = pc_base::load_model("zyfxmember_model");
		$this->member = pc_base::load_model("member_model");
		$this->_userid = param::get_cookie('_userid');
	}
	function shareLogin()
	{

		include template('zynewmember', 'login');
	}
	function shareRegister()
	{
		include template('zynewmember', 'register');
	}
	function turnTo()
	{
		$_userid = $this->_userid;
		$member =  $this->member->get_one(["userid"=>$_userid]);
		include template('zynewmember', 'l1');
	}
	public function show_member()
	{
		$_userid = $this->_userid;
		$member =  $this->fx->get_one(["userid"=>$_userid]);
		if($member["iscaptain"] == 2)
			include template('zyqrcode','show_member');
		else
			showmessage(L('请先升级为团长'), '?m=zymember&c=index&a=init', '1000');
	}
	/*
	 * 显示信息
	 * */
	public function index_show()
	{
	    if($_GET['obj']){
	        $project=$_GET['obj'];
        }
	    //echo $this->strget(APP_PATH.'uploadfile/qrcode/1552286253.png');
        //echo $this->scerweima1('https://www.baidu.com');
		//echo $this->update_qrcode('http://www.baidu.com','uploadfile/qrcode/1552286253.png');//调用查看结果
		include template('zyqrcode','index');
	}

	/*
	 * 输入邀请码
	 * */
	public function invite()
	{
		include template('zyqrcode','invite');
	}
}
?>