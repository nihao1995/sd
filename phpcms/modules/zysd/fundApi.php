<?php
/**
 * Created by PhpStorm.
 * User: 徐强
 * Date: 2019/7/12
 * Time: 8:41
 */
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_func('global');
pc_base::load_sys_class('form', '', 0);
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('Res', '', 0);

use zymember\classes\FundControl as fc;
use zysd\classes\SdControl as sd;

class fundApi
{
    public $fund;
    public $sd;
    function __construct()
    {
        $this->fund = new fc();
        $this->sd = new sd();
    }

    //添加银行卡
    public function add_bank_card(){
        $data=checkArg(["userid"=>[true,6,"请输入用户ID"],"bank_cardid"=>[true,0,"请输入银行卡号"],"bank_name"=>[true,0,"请输入开户银行"],"bank_branch"=>[true,0,"请输入所属支行"],"owner_name"=>[true,0,"请输入持卡人姓名"]],$_POST);
        $id=$this->fund->add_bank_card($data);
        if($id){
            returnAjaxData(200,"操作成功",$id);
        }else{
            returnAjaxData(-200,"操作失败");
        }
    }

    //编辑银行卡
    public function edit_bank_card(){
        $data=checkArg(["userid"=>[true,6,"请输入用户ID"],"BID"=>[true,1,"请输入ID"],"bank_cardid"=>[false,0,"请输入银行卡号"],"bank_name"=>[false,0,"请输入开户银行"],"bank_branch"=>[false,0,"请输入所属支行"],"owner_name"=>[false,0,"请输入持卡人姓名"]],$_POST);
        $id=$this->fund->edit_bank_card($data,$data['BID']);
        if($id){
            returnAjaxData(200,"操作成功",$id);
        }else{
            returnAjaxData(-200,"操作失败");
        }
    }

    //删除银行卡
    public function del_bank_card(){
        $data=checkArg(["BID"=>[true,1,"请输入ID"],["userid"=>[true, 6,"请输入用户ID"]]],$_POST);
        $id=$this->fund->del_bank_card($data);
        if($id){
            returnAjaxData(200,"操作成功",$id);
        }else{
            returnAjaxData(-200,"操作失败");
        }
    }

    //银行卡信息
    public function get_bank_card()
    {
        $data=checkArg(["userid"=>[true,6,"请输入用户ID"],"page"=>[false,0,"请输入page"],"pagesize"=>[false,0,"请输入pagesize"]],$_POST);
        $where="1";
        if($data['userid']){
            $where.=" AND userid=".$data['userid'];
        }
        list($info,$pagenums, $pageStart, $pageCount)=$this->fund->bank_card_list($where,1,50,"BID,bank_cardid,bank_name,owner_name,bank_branch,status");
        if($info){
            foreach ($info as $key=> $item) {
                $info[$key]['bank_cardid']=preg_replace('/^(.{4})(?:\d+)(.{4})$/', '$1****$2', $item['bank_cardid']);
            }
            $config=$this->sd->get_system_config("platform_bankcard_number,platform_bankcard_name,platform_bankcard_keeper");
            returnAjaxData(200,"操作成功",['data'=>$info,'pagenums'=>$pagenums, 'pageStart'=>$pageStart, 'pageCount'=>$pageCount,"platform_bankcard"=>$config]);
        }else{
            returnAjaxData(-199,"暂无银行卡数据，请先绑定",['data'=>$info,'pagenums'=>$pagenums, 'pageStart'=>$pageStart, 'pageCount'=>$pageCount]);
        }

    }


    //银行卡详情
    public function get_one_bank_card()
    {
        $data=checkArg(["userid"=>[true,6,"请输入用户ID"],"BID"=>[true,1,"请输入ID"]],$_POST);
        list($info,$pagenums, $pageStart, $pageCount)=$this->fund->bank_card_list($data,1,50,"BID,bank_cardid,bank_name,owner_name,bank_branch,status");
        if($info){
            $data=$info[0];
            $data['platform_bankcard']=$this->sd->get_system_config("platform_bankcard_number,platform_bankcard_name,platform_bankcard_keeper");
            returnAjaxData(200,"操作成功",$data);
        }else{
            returnAjaxData(-200,"暂无数据");
        }
    }


    //账本记录
    public function account_records()
    {
        $data=checkArg(["userid"=>[true,6,"请输入用户ID"],"type"=>[true,1,"请输入类型"],"page"=>[true,0,"请输入page"],"pagesize"=>[true,0,"请输入pagesize"]],$_POST);
        $where="userid=".$data['userid']." AND type=".$data['type']." AND account_type IN (1,2)";
        $info=$this->fund->account_list($where,$data['page'],$data['pagesize']);
        if($info){
            returnAjaxData(200,"操作成功",['data'=>$info[0], 'pageCount'=>$info[1]]);
        }else{
            returnAjaxData(-200,"暂无数据");
        }
    }


    //充值申请
    public function cz_apply()
    {
        $data=checkArg(["userid"=>[true,6,"请输入用户ID"],"proof_thumb"=>[true,0,"请上传凭证"],"fund_money"=>[true,1,"请输入提现金额"],"note"=>[false,0]],$_POST);
//        $bankcard=$this->fund->bank_card_list(["BID"=>$data['bankcard_id']])[0];
//        if(!$bankcard[0]){
//            returnAjaxData(-1,"银行卡不存在");
//        }else{
//            if($bankcard[0]['userid']!=$data['userid']) returnAjaxData(-100,"非法操作");
//        }
        $data["addtime"] = date("Y-m-d H:i:s",time());
        $data["fund_type"] = 1;
        $id=$this->fund->fund_application($data);
        if($id){
            returnAjaxData(200,"操作成功",$id);
        }else{
            returnAjaxData(-200,"操作失败");
        }
    }

    //提现申请
    public function tx_apply()
    {
        $data=checkArg(["userid"=>[true,6,"请输入用户ID"],"fund_money"=>[true,1,"请输入提现金额"],"bankcard_id"=>[true,0,"请选择银行卡"],"password"=>[true,0,"请输入提现密码"]],$_POST);
        $member=$this->fund->check_user($data['userid']);
        if(empty($member['trade_password'])||empty($member['trade_encrypt'])){
            returnAjaxData(-199,"请先设置提现密码");
        }
        if($member['trade_password']!=password($data['password'],$member['trade_encrypt'])){
            returnAjaxData(-198,"密码错误");
        }
        $bankcard=$this->fund->bank_card_list(["BID"=>$data['bankcard_id']])[0];
        if(!$bankcard[0]){
            returnAjaxData(-1,"银行卡不存在");
        }else{
            if($bankcard[0]['userid']!=$data['userid']) returnAjaxData(-100,"非法操作");
        }
        $info=[
            'userid'=>$data['userid'],
            'fund_type'=>2,
            'fund_money'=>$data['fund_money'],
            'bankcard_id'=>$data['bankcard_id'],
            'addtime'=>date("Y-m-d H:i:s",time()),
        ];
        $id=$this->fund->fund_application($info);
        if($id){
            returnAjaxData(200,"操作成功",$id);
        }else{
            returnAjaxData(-200,"操作失败");
        }
    }

    //资金记录
    public function fund_record()
    {
        $neadArg = ["userid"=>[true,6,"请输入用户ID"],"fund_type"=>[true,1,"请输入金额类型"],"page"=>[true,0,"请输入page"],"pagesize"=>[true,0,"请输入pagesize"]];
        $data=checkArg($neadArg,$_POST);
        $member=$this->fund->check_user($data['userid']);
        list($info,$pagenums, $pageStart, $pageCount)=$this->fund->fund_list("B1.userid=".$data['userid']." and fund_type=".$data['fund_type'],1,$data['page'],$data['pagesize']);
        if($info){
            returnAjaxData(200,"操作成功",['data'=>$info, 'pageCount'=>$pageCount,'middle_station'=>$member['middle_station']]);
        }else{
            returnAjaxData(-200,"操作失败");
        }
    }

    //个人资金
    public function fund_info()
    {
        $neadArg = ["userid"=>[true,6,"请输入用户ID"]];
        $data=checkArg($neadArg,$_POST);
        $info=$this->fund->fund_info($data['userid']);
        if($info){
            returnAjaxData(200,"操作成功",$info);
        }else{
            returnAjaxData(-200,"操作失败");
        }
    }

}