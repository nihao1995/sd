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
        $this->update_order_status($where['userid']);
        list($info, $count) = mf::dbFactory("notice")->moreTableSelect(array('zy_order'=>array("*"), 'zy_zyshop'=>array('*')), array("SID"), $where, ((string)($page-1)*$pagesize).",".$pagesize, "gettime DESC,status asc","1");
        list($page, $pagenums, $pageStart, $pageCount) = getPage($page, $pagesize, $count);
        if($info) {
            foreach ($info as $key => $item) {
                $info[$key]['end_timestamp'] = strtotime($info[$key]['endtime']);
                $config=$this->sd->get_system_config();
                $info[$key]['freeze_timestamp'] = strtotime($info[$key]['gettime'])+$config['freeze_time'];
                $info[$key]['left_timestamp'] = strtotime($info[$key]['gettime'])+$config['limit_time'];
            }
        }
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
//            return $goods[$random_keys];
            $where2=[
                'userid'=>$userid,
                'isDefault'=>1,
            ];
            $ADID=mf::dbFactory("zyaddress")->get_one($where2);
            if(!$ADID) {
                $where2=[
                    'userid'=>$userid,
                ];
                $ADID = mf::dbFactory("zyaddress")->get_one($where2);
                if(!$ADID) {
                    returnAjaxData(-1,"请先填写地址");
                }
            }
            if($goods[$random_keys]['residueNum']<=0){
                returnAjaxData(-201,'订单已被抢完');
            }
            if(strtotime($goods[$random_keys]['endtime'])<=time()){
                returnAjaxData(-202,'订单已过期');
            }
            $order_limit_times=$config['order_limit_times']+$member_info['extra_times'];
            $where='TO_DAYS(gettime) = TO_DAYS(NOW()) AND userid='.$userid;
            $times=mf::dbFactory("order")->count($where);
            if($times>=$order_limit_times){
                returnAjaxData(-203,"今日订单达到上限");
            }
            $data=[
                'order_sn'=>create_transaction_code(),
                'userid'=>$userid,
                'SID'=>$goods[$random_keys]['SID'],
                'gettime'=>date("Y-m-d H:i:s",time()),
                'ADID'=>$ADID['ADID'],
                'status'=>1,
            ];
            $id=mf::dbFactory("zyshop")->update(['residueNum'=>'-=1'],['SID'=>$goods[$random_keys]['SID']]);
            $id=mf::dbFactory("order")->insert($data,true);
            $order=mf::dbFactory("order")->get_one(['OID'=>$id]);
            $goods[$random_keys]['OID']=$id;
            $goods[$random_keys]['thumbs']=json_decode($goods[$random_keys]['thumbs'],true);
            $goods[$random_keys]['brokerage']=json_decode($goods[$random_keys]['brokerage'],true);
            $goods[$random_keys]['left_time']=strtotime($order['gettime'])+$config['limit_time'];
            returnAjaxData(200,"抢单成功",$goods[$random_keys]);
        }else{
            returnAjaxData(-200,"订单抢完了");
        }
    }

    /**
     * 接取订单
     * @param $userid
     * @param $SID
     * @return mixed
     */
    function get_task($userid,$SID,$ADID){
        returnAjaxData(404,"该接口已弃用");
        $data=[
            'order_sn'=>create_transaction_code(),
            'userid'=>$userid,
            'SID'=>$SID,
            'gettime'=>date("Y-m-d H:i:s",time()),
            'ADID'=>$ADID,
            'status'=>1,
        ];
        $goods=mf::dbFactory("zyshop")->get_one(array('SID'=>$SID));
        if($goods['residueNum']<=0){
            returnAjaxData(-201,'订单已被抢完');
        }
        if(strtotime($goods['endtime'])<=time()){
            returnAjaxData(-202,'订单已过期');
        }
        $id=$this->fc->add_account_record($userid,3,$goods['money'],2,true);

        $id=mf::dbFactory("zyshop")->update(['residueNum'=>'-=1'],['SID'=>$SID]);
        $id=mf::dbFactory("order")->insert($data,true);
        return $id;
    }

    /**
     * 任务详情
     * @param $where
     * @return array
     */
    function task_detail($where){
        $info = mf::dbFactory("zyshop")->get_one($where);
        $info['end_timestamp']=strtotime($info['endtime']);
        return $info;
    }

    /**
     * 订单详情
     * @param $where
     * @return array
     */
    function order_detail($where){
        list($info,$count) = mf::dbFactory("notice")->moreTableSelect(array('zy_order'=>array("*"), 'zy_zyshop'=>array('*'), 'zy_zyaddress'=>array('*')), array("SID","ADID"), $where,'','');
        if(!$info){
            return false;
        }
        $config=$this->sd->get_system_config();
        $info['end_timestamp']=strtotime($info['endtime']);
        $info['freeze_timestamp'] = strtotime($info['gettime'])+$config['freeze_time'];
        $info['thumbs']=json_decode($info['thumbs'],true);
        $info['brokerage']=json_decode($info['brokerage'],true);
        $info['left_time']=strtotime($info['gettime'])+$config['limit_time'];
        return $info;
    }

    /**
     * 完成订单
     * @param $userid
     * @param $OID
     * @return mixed
     */
    function finish_task($userid,$OID,$ADID){
        $this->update_order_status($userid);
        LIST($order,$count)=mf::dbFactory("order")->moreTableSelect(array('zy_order'=>array("*"), 'zy_zyshop'=>array('*')), array("SID"), ['OID'=>$OID,'userid'=>$userid],'','');
        if($order) {
            if($ADID){
                $id = mf::dbFactory("order")->update(['ADID'=>$ADID],['OID'=>$OID]);
            }
            if($order['status']==1){//完成订单
                $id = $this->fc->add_account_record($userid, 5, $order['awardMoney'], 1, true);
                $param = ["userid"=>$userid, "SID"=>$order["SID"]];
                $val = json_decode(_crul_post(APP_PATH."index.php?m=zyfx&c=frontApi&a=awardMoney", $param));
                //分销代码++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            }elseif($order['status']==2){//解冻
                $id = $this->fc->add_account_record($userid, 4, $order['money'], 1, true);
            }else{
                returnAjaxData(-201,"状态错误");
            }

            $id = mf::dbFactory("order")->update(['status'=>3],['OID'=>$OID]);
        }else{
            returnAjaxData(-200,"无效订单");
        }
        return $id;
    }

    /**
     * 统计数据
     * @param $userid
     * @return mixed
     */
    function statis($userid){
        $this->update_order_status($userid);
        $data['commission']=0;
        $where="TO_DAYS(gettime) = to_days(now()) AND userid=".$userid;
        $data['all_num']=mf::dbFactory("order")->get_one($where,'count(*) as num')['num'];
        $where.=" AND status=2";
        $data['frozen_num']=mf::dbFactory("order")->get_one($where,'count(*) as num')['num'];
        //$sql="select sum(money) as num from zy_order LEFT JOIN zy_zyshop ON zy_order.SID=zy_zyshop.SID WHERE ".$where;
        //mf::dbFactory("order")->spcSql($sql,1,1);
        $data['frozen_amount']=mf::dbFactory("member")->get_one(['userid'=>$userid])['frozen_amount'];
        $data['total_team_amount']=0;
        return $data;
    }

    /**
     * 更新订单状态
     * @param $userid
     * @return mixed
     */
    function update_order_status($userid){
        if(empty($userid)){
            returnAjaxData(-1,"缺少参数");
        }
        $order=mf::dbFactory("order")->select(['status'=>1,'userid'=>$userid]);
        $config=$this->sd->get_system_config();
        foreach($order as $key=>$value){
            if(strtotime($value['gettime'])+$config['limit_time']<=time()){
                $info = mf::dbFactory("order")->update(['is_freeze'=>1,'status'=>2,'gettime'=>date("Y-m-d H:i:s",(strtotime($value['gettime'])+$config['limit_time']))],['OID'=>$value['OID']]);
                $goods=mf::dbFactory("zyshop")->get_one(array('SID'=>$value['SID']));
                $this->fc->add_account_record($userid,3,$goods['money'],2,true);
            }
        }
    }

}