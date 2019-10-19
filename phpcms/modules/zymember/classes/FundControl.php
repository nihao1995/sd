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
    function __construct($type)
    {

    }

    /**
     * 检查用户状态
     * @param $userid
     * @return bool
     */
    function check_user($userid){
        $member=mf::dbFactory('member')->get_one(['userid'=>$userid]);
        if($member){
            if($member['islock']==1){
                returnAjaxData(-2,"用户已被锁定");
            }else{
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
     * @param $where
     * @return mixed
     */
    function edit_bank_card($data,$where){
        if(empty($data)){
            returnAjaxData(-1,"缺少参数");
        }
        $this->check_user($data['userid']);
        $card=mf::dbFactory('bankcard')->get_one(['bank_cardid'=>$data['bank_cardid']]);
        if($card&&$card['bid']){
            returnAjaxData(-2,"银行卡已绑定");
        }
        $id=mf::dbFactory('bankcard')->update($data,$where);
        return $id;
    }

    /**
     * 删除银行卡
     * @param $data
     * @param $where
     * @return mixed
     */
    function del_bank_card($id){

    }
}