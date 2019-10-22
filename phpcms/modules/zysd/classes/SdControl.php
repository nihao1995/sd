<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/18
 * Time: 14:48
 */

namespace zysd\classes;

use zymember\classes\modelFactory as mf;

class FundControl
{
    function __construct($type)
    {

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