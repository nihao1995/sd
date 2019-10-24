<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_func('global');

use zysd\classes\SdControl as sd;
class api{
	public $sd;
	function __construct()
	{
		$this->sd = new sd();
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
	//公告类型
	function notice_type_list(){
		$where="status=1";
		$info=$this->sd->notice_type_all($where);
		if($info){
			returnAjaxData(200,"操作成功",$info);
		}else{
			returnAjaxData(200,"暂无数据");
		}
	}
	//公告列表
	function notice_list(){
		$data=checkArg(["siteid"=>[true,1,"请输入类型"],"page"=>[true,0,"请输入page"],"pagesize"=>[false,0,"请输入pagesize"]],$_POST);
		$where=["passed"=>1,'siteid'=>$data['siteid']];
		list($info,$pagenums, $pageStart, $pageCount)=$this->sd->notice_list($where,$data['page']);
		if($info){
			returnAjaxData(200,"操作成功",['data'=>$info,'pagenums'=>$pagenums, 'pageStart'=>$pageStart, 'pageCount'=>$pageCount]);
		}else{
			returnAjaxData(200,"暂无数据",['data'=>$info,'pagenums'=>$pagenums, 'pageStart'=>$pageStart, 'pageCount'=>$pageCount]);
		}
	}
	//公告详请
	function notice_detail(){
		$data=checkArg(["aid"=>[true,1,"请输入ID"]],$_POST);
		$data['passed']=1;
		list($info,$pagenums, $pageStart, $pageCount)=$this->sd->notice_list($data);
		if($info){
			returnAjaxData(200,"操作成功",$info);
		}else{
			returnAjaxData(200,"暂无数据");
		}
	}
}
?>
