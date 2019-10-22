<?php

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);	//加载应用类方法
pc_base::load_sys_class('form', 0, 0);
pc_base::load_app_func('global');
use zymember\classes\FundControl as fc;
class zysd extends admin {
	/**
	*构造函数，初始化
	*/
	public function __construct()
	{
		$this->fund = new fc();
	}

	//---------------------------------------------------后台模板--------------------------------------------------------

	/**
	 * 充值-列表
	 */
	public function rechargeManage()
	{
		include $this->admin_tpl('fund/rechargeManage');
	}
	/**
	 * 提现-列表
	 */
	public function cashManage()
	{
		include $this->admin_tpl('fund/cashManage');
	}
	/**
	 * 银行卡-列表
	 */
	public function bankcardManage()
	{
		include $this->admin_tpl('fund/bankcardManage');
	}
	/**
	 * 添加银行卡
	 */
	public function add_bankcard()
	{
		if(!empty($_POST))
		{
			$neadArg = ['userid'=>[true, 1,"请输入用户id"], "bank_name"=>[true, 0, "请输入银行名称"],"bank_cardid"=>[true, 0, "请输入银行卡号"],"owner_name"=>[true, 0,"请输入持卡人姓名"],'bank_branch'=>[true, 0,"请输入开户银行"]];
			$data = checkArg($neadArg, $_POST);
			$this->fund->check_user($data['userid']);
			$bool=$this->fund->add_bank_card($data);
			if($bool) {
				returnAjaxData(200, '添加成功');
			}else{
				returnAjaxData(-200, '添加失败');
			}
		}
		else {
			include $this->admin_tpl('fund/bankcardAdd');
		}
	}

	/**
	 * 添加银行卡
	 */
	public function edit_bankcard()
	{
		if(!empty($_POST))
		{
			$neadArg = ['BID'=>[true, 1,"请输入id"],'userid'=>[true, 1,"请输入用户id"], "bank_name"=>[true, 0, "请输入银行名称"],"bank_cardid"=>[true, 0, "请输入银行卡号"],"owner_name"=>[true, 0,"请输入持卡人姓名"],'bank_branch'=>[true, 0,"请输入开户银行"]];
			$data = checkArg($neadArg, $_POST);
			$where = array_shift($data);
			$this->fund->check_user($data['userid']);
			$bool=$this->fund->edit_bank_card($data,$where);
			if($bool) {
				returnAjaxData(200, '修改成功');
			}else{
				returnAjaxData(-200, '修改失败');
			}
		}
		else {
			$data = checkArg(['ID'=>[true, 1,"请输入id"]],$_GET);
			$info=$this->fund->bank_card_list(array('BID'=>$data['ID']))[0];
			$dataInfo=$info[0];
			include $this->admin_tpl('fund/bankcardEdit');
		}
	}


	//---------------------------------------------------后台模板--------------------------------------------------------

	//提现充值记录
	public function fund_records()
	{
		$data=checkArg(["userid"=>[false,1,"请输入用户ID"],"type"=>[true,1,"请输入类型"],"fund_type"=>[true,1,"请输入资金类型"],"time"=>[false,0,"请选择时间"],"page"=>[false,0,"请输入page"],"pagesize"=>[false,0,"请输入pagesize"]],$_POST);
		$where="fund_type=".$data['fund_type'];
		if($data['userid']){
			$where.=" AND B1.userid=".$data['userid'];
		}
		if($data['time']){
			$where.=" AND addtime>='".date("Y-m-d H:i:s",strtotime($data['time'][0]))."' AND addtime<='".date("Y-m-d H:i:s",strtotime($data['time'][1]))."'";
		}
		list($info,$pagenums, $pageStart, $pageCount)=$this->fund->fund_list($where,$data['type'],$data['page']);
		if($info){
			returnAjaxData(200,"操作成功",['data'=>$info,'pagenums'=>$pagenums, 'pageStart'=>$pageStart, 'pageCount'=>$pageCount]);
		}else{
			returnAjaxData(200,"暂无数据",['data'=>$info,'pagenums'=>$pagenums, 'pageStart'=>$pageStart, 'pageCount'=>$pageCount]);
		}
	}

	//提现充值--审核通过
	public function fund_pass()
	{
		$data=checkArg(["FRID"=>[true,1,"请输入ID"]],$_POST);
		$info=$this->fund->fund_pass($data['FRID']);
		if($info){
			returnAjaxData(200,"操作成功");
		}else{
			returnAjaxData(200,"暂无数据");
		}
	}
	//提现充值--审核驳回
	public function fund_dismiss()
	{
		$data=checkArg(["FRID"=>[true,1,"请输入ID"]],$_POST);
		$info=$this->fund->fund_dismiss($data['FRID']);
		if($info){
			returnAjaxData(200,"操作成功");
		}else{
			returnAjaxData(200,"暂无数据");
		}
	}

	//删除提现充值记录
	public function del_fund()
	{
		$data=checkArg(["FRID"=>[true,0,"请输入ID"]],$_POST);
		$info=$this->fund->del("fund_record","FRID",$data['FRID']);
		if($info){
			returnAjaxData(200,"操作成功");
		}else{
			returnAjaxData(-200,"操作失败");
		}
	}

	//提现充值记录
	public function bankcard_list()
	{
		$data=checkArg(["userid"=>[false,1,"请输入用户ID"],"owner_name"=>[false,0,"请输入持卡人姓名"],"page"=>[false,0,"请输入page"],"pagesize"=>[false,0,"请输入pagesize"]],$_POST);
		$where="1";
		if($data['userid']){
			$where.=" AND userid=".$data['userid'];
		}
		if($data['owner_name']){
			$where.=" AND owner_name like '%".$data['owner_name']."%'";
		}
		list($info,$pagenums, $pageStart, $pageCount)=$this->fund->bank_card_list($where,$data['page']);
		if($info){
			returnAjaxData(200,"操作成功",['data'=>$info,'pagenums'=>$pagenums, 'pageStart'=>$pageStart, 'pageCount'=>$pageCount]);
		}else{
			returnAjaxData(200,"暂无数据",['data'=>$info,'pagenums'=>$pagenums, 'pageStart'=>$pageStart, 'pageCount'=>$pageCount]);
		}
	}

	//删除提现充值记录
	public function del_bankcard()
	{
		$data=checkArg(["BID"=>[true,0,"请输入ID"]],$_POST);
		$info=$this->fund->del("bankcard","BID",$data['BID']);
		if($info){
			returnAjaxData(200,"操作成功");
		}else{
			returnAjaxData(-200,"操作失败");
		}
	}

}
?>