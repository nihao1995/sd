<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/18
 * Time: 14:48
 */

namespace zysd\classes;

use zymember\classes\modelFactory as mf;
use zysd\classes\SdControl as sd;
use zymember\classes\FundControl as fc;

class OrderControl
{
    function __construct()
    {
        $this->sd=new sd();
        $this->fc=new fc();
    }

    /**
     * 订单列表
     * @param $where
     * @param int $page
     * @param int $pagesize
     * @return array
     */
    function order_list($where,$page=1,$pagesize=20){
        list($info, $count) = mf::dbFactory("notice")->moreTableSelect(array('zy_order'=>array("*"), 'zy_zyshop'=>array('*')), array("SID"), $where, ((string)($page-1)*$pagesize).",".$pagesize, "gettime DESC,status asc","1");
        list($page, $pagenums, $pageStart, $pageCount) = getPage($page, $pagesize, $count);
        return [$info,$pagenums, $pageStart, $pageCount];
    }

    /**
     * 自动抢单
     * @param $userid
     * @return mixed
     */
    function auto_grab_order($userid){
        $config=$this->sd->get_system_config();
        $member_info=$this->fc->check_user($userid);
        $where='residueNum>0 and endtime>"'.date("Y-m-d H:i:s",time()).'" AND money >='.($member_info['amount']*$config['task_lowerlimit']/100).' and money <='.($member_info['amount']*$config['task_toplimit']/100);
        $goods=mf::dbFactory("zyshop")->select($where);
        if($goods){
            $random_keys=array_rand($goods,1);
            $goods[$random_keys]['end_timestamp']=strtotime($goods[$random_keys]['endtime']);
            return $goods[$random_keys];
        }else{
            returnAjaxData(-200,"订单抢完了");
        }
    }

    /**
     * 任务详情
     * @param $where
     * @return array
     */
    function task_detail($where){
        $info = mf::dbFactory("zyshop")->get_one($where);
        return $info;
    }

    /**
     * 接取任务
     * @param $userid
     * @param $SID
     * @return mixed
     */
    function get_task($userid,$SID){
        $data=[
            'order_sn'=>create_transaction_code(),
            'userid'=>$userid,
            'SID'=>$SID,
            'gettime'=>time(),
            'status'=>0,
        ];
        $goods=mf::dbFactory("zyshop")->get_one(array('SID'=>$SID));
        if($goods['residueNum']<=0){
            returnAjaxData(-201,'任务已被抢完');
        }
        if(strtotime($goods['endtime'])<=time()){
            returnAjaxData(-202,'任务已过期');
        }
        $member=mf::dbFactory("member")->get_one(['userid'=>$userid]);
        if($member['amount']<$goods['money']){
            returnAjaxData(-202,'余额不足');
        }
        $id=mf::dbFactory("zyshop")->update(['residueNum'=>'-=1'],['SID'=>$SID]);
        $id=mf::dbFactory("order")->insert($data,true);
        $id=mf::dbFactory("member")->update(['amount'=>'-='.$goods['money'],'frozen_amount'=>'+='.$goods['money']],['userid'=>$userid]);
        return $id;
    }





}