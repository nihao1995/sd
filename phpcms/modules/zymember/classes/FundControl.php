<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/18
 * Time: 14:48
 */

namespace zymember\classes;

use zymember\classes\modelFactory as mf;

class FundControl
{
    function __construct()
    {

    }

    /**
     * 状态替换
     * @param $status
     * @param string $meg
     * @param bool $is_back
     * @return string
     */
    function fund_status($status,$meg='',$is_back=false){
        if($is_back){
            switch($status){
                case 0 : return "待审核";
                case 1 : return $meg."成功";
                case 2 : return $meg."失败";
            }
        }else{
            switch($status){
                case 0 : return "正在审核中";
                case 1 : return $meg."成功";
                case 2 : return $meg."失败";
            }
        }
    }

    /**
     * 删除通用
     * @param $db
     * @param $key
     * @param $val
     * @return bool
     */
    function del($db,$key,$val){
        if(is_array($val)){
            $indata=join(",",$val);
            $bool=mf::dbFactory($db)->delete($key." in(".$indata.")");
        }else{
            $bool=mf::dbFactory($db)->delete([$key=>$val]);
        }
        if($bool){
            return true;
        }else{
            returnAjaxData(-200,"删除失败");
        }
    }

    /**
     * 检查用户状态
     * @param $userid
     * @return bool
     */
    function check_user($userid){
        if(empty($userid)){
            returnAjaxData(-1,"缺少参数");
        }
        $member=mf::dbFactory('member')->get_one(['userid'=>$userid]);
        if($member){
            if($member["islock"]==1){
                returnAjaxData(-1,"用户已锁定");
            }
        }else{
            returnAjaxData(-1,"用户不存在");
        }
        return true;
    }

    /**
     * 添加银行卡
     * @param $data
     * @return mixed
     */
    function add_bank_card($data){
        if(empty($data)){
            returnAjaxData(-1,"缺少参数");
        }
        $this->check_user($data['userid']);
        $card=mf::dbFactory('bankcard')->get_one(['bank_cardid'=>$data['bank_cardid']]);
        if($card){
            returnAjaxData(-2,"银行卡已绑定");
        }
        $id=mf::dbFactory('bankcard')->insert($data,true);
        return $id;
    }

    /**
     * 修改银行卡
     * @param $data
     * @param $BID
     * @return mixed
     */
    function edit_bank_card($data,$BID){
        if(empty($data)||empty($BID)){
            returnAjaxData(-1,"缺少参数");
        }
        $this->check_user($data['userid']);
        $card=mf::dbFactory('bankcard')->get_one(['bank_cardid'=>$data['bank_cardid']]);
        if($card&&$card['BID']!=$BID){
            returnAjaxData(-2,"银行卡已绑定");
        }
        $id=mf::dbFactory('bankcard')->update($data,['BID'=>$BID]);
        return $id;
    }

    /**
     * 删除银行卡
     * @param $BID
     * @return mixed
     */
    function del_bank_card($BID){
        if(empty($BID)){
            returnAjaxData(-1,"缺少参数");
        }
        $id=mf::dbFactory('bankcard')->delete($BID);
        return $id;
    }

    /**
     * 银行卡列表
     * @param $where
     * @param int $page
     * @param int $pagesize
     * @param $filed
     * @return array
     */
    function bank_card_list($where,$page=1,$pagesize=20,$filed="*"){
        $info = mf::dbFactory("bankcard")->listinfo($where,"BID DESC",$page,$pagesize,'','','','',$filed);
        $count= mf::dbFactory("bankcard")->number;
        list($page, $pagenums, $pageStart, $pageCount) = getPage($page, $pagesize, $count);
        return [$info,$pagenums, $pageStart, $pageCount];
    }

    /**
     * 添加资金记录
     * @param $userid 用户id
     * @param $account_type 账变类型 1 充值 2 提现 3 购买 4 卖出
     * @param $money 金额
     * @param $type 金额类型 1 收入 2 支出
     * @param $is_update_member 是否更新资金 true/false
     * @return mixed
     */
    function add_account_record($userid,$account_type,$money,$type,$is_update_member=false){
        if($money<=0){
            returnAjaxData(-99,'金额错误');
        }
        if($is_update_member){
            if($type==1){
                mf::dbFactory('member')->update(['amount'=>"+=".$money]);
            }elseif($type==2){
                mf::dbFactory('member')->update(['amount'=>"-=".$money]);
            }else{
                returnAjaxData(-101,'金额类型错误');
            }
        }
        $data=[
            'userid'=>$userid,
            'account_type'=>$account_type,
            'money'=>$money,
            'type'=>$type,
            'addtime'=>date("Y-m-d H:i:s",time()),
        ];
        $id=mf::dbFactory('account_record')->insert($data);
        return $id;
    }

    /**
     * 充值/提现申请
     * @param $data
     * @return mixed
     */
    function fund_application($data){
        if(empty($data)){
            returnAjaxData(-1,"缺少参数");
        }
        $id=mf::dbFactory('fund_record')->insert($data);
        return $id;
    }

    /**
     * 充值/提现申请--通过
     * @param $frid
     * @return mixed
     */
    function fund_pass($frid){
        if(empty($frid)){
            returnAjaxData(-1,"缺少参数");
        }
        $info=mf::dbFactory('fund_record')->get_one(['frid'=>$frid]);
        if(!$info||$info['status']!=0){
            returnAjaxData(-1,"状态错误");
        }
        $id=mf::dbFactory('fund_record')->update(['status'=>1],['frid'=>$frid]);
        $fund_record=mf::dbFactory('fund_record')->get_one(['frid'=>$frid]);
        //添加资金记录及资金
        if($fund_record['fund_type']==1) {
            $this->add_account_record($fund_record['userid'], 1, $fund_record['fund_money'], 1, true);
        } elseif($fund_record['fund_type']==2) {
            $this->add_account_record($fund_record['userid'], 2, $fund_record['fund_money'], 2, true);
        }
        return $id;
    }

    /**
     * 充值/提现申请--驳回
     * @param $frid
     * @return mixed
     */
    function fund_dismiss($frid){
        if(empty($frid)){
            returnAjaxData(-1,"缺少参数");
        }
        $info=mf::dbFactory('fund_record')->get_one(['frid'=>$frid]);
        if(!$info||$info['status']!=0){
            returnAjaxData(-1,"状态错误");
        }
        $id=mf::dbFactory('fund_record')->update(['status'=>2],['frid'=>$frid]);
        return $id;
    }

    /**
     * 充值/提现记录列表
     * @param $where
     * @param $type 0 默认不做处理 1 前台 2后台
     * @return mixed
     */
    function fund_list($where,$type=0,$page=1,$pagesize=20){
        $msg='';
        if($type==1){
            list($info, $count) = mf::dbFactory("fund_record")->moreTableSelect(array('zy_fund_record'=>array("*"), 'zy_bankcard'=>array('*')), array(["bankcard_id","BID"]), $where, ((string)($page-1)*$pagesize).",".$pagesize, "B1.addtime DESC,status asc","1");
            list($page, $pagenums, $pageStart, $pageCount) = getPage($page, $pagesize, $count);
        }elseif($type==2){
            list($info, $count) = mf::dbFactory("fund_record")->moreTableSelect(array('zy_fund_record'=>array("*"), 'zy_bankcard'=>array('*')), array(["bankcard_id","BID"]), $where, ((string)($page-1)*$pagesize).",".$pagesize, "B1.addtime DESC,status asc","1");
            list($page, $pagenums, $pageStart, $pageCount) = getPage($page, $pagesize, $count);
        }else{
            $info=mf::dbFactory('fund_record')->listinfo($where,"addtime DESC",$page,$pagesize);
        }
//        foreach ($info as $key=> $item) {
//            if($item['fund_type']==1){
//                $msg='充值';
//            }elseif($item['fund_type']==2){
//                $msg='提现';
//            }
//            $info[$key]['status']=$this->fund_status($item['status'],$msg);
//        }
        return [$info,$pagenums, $pageStart, $pageCount];
    }

    /**
     * 账本记录列表
     * @param $where
     * @param $type 0 默认不做处理 1 前台 2后台
     * @return mixed
     */
    function account_list($where,$page=1,$pagesize=20){
        $order = 'addtime DESC';
        $info=mf::dbFactory('account_record')->listinfo($where,$order,$page,$pagesize);
        return $info;
    }

}