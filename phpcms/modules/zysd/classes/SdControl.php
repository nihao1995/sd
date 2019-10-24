<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/18
 * Time: 14:48
 */

namespace zysd\classes;

use zymember\classes\modelFactory as mf;

class SdControl
{
    function __construct($type)
    {

    }

    /**
     * 公告类型列表
     * @param $where
     * @param int $page
     * @param int $pagesize
     * @return array
     */
    function notice_type_list($where,$page=1,$pagesize=20){
        $info = mf::dbFactory("notice_type")->listinfo($where,"sort asc,NTID asc",$page,$pagesize);
        $count= mf::dbFactory("notice_type")->number;
        list($page, $pagenums, $pageStart, $pageCount) = getPage($page, $pagesize, $count);
        return [$info,$pagenums, $pageStart, $pageCount];
    }

    /**
     * 公告类型列表
     * @param $where
     * @return array
     */
    function notice_type_all($where){
        $info = mf::dbFactory("notice_type")->select($where,'*','',"sort asc,NTID asc");
        return $info;
    }

    /**
     * 添加公告类型
     * @param $data
     * @return mixed
     */
    function add_notice_type($data){
        if(empty($data)){
            returnAjaxData(-1,"缺少参数");
        }
        $card=mf::dbFactory('notice_type')->get_one(['notice_type_name'=>$data['notice_type_name']]);
        if($card){
            returnAjaxData(-2,"公告类型重复");
        }
        $id=mf::dbFactory('notice_type')->insert($data,true);
        return $id;
    }

    /**
     * 修改公告类型
     * @param $data
     * @param $NTID
     * @return mixed
     */
    function edit_notice_type($data,$NTID){
        if(empty($data)||empty($NTID)){
            returnAjaxData(-1,"缺少参数");
        }
        $card=mf::dbFactory('notice_type')->get_one(['notice_type_name'=>$data['notice_type_name']]);
        if($card&&$card['NTID']!=$NTID){
            returnAjaxData(-2,"公告类型重复");
        }
        $id=mf::dbFactory('notice_type')->update($data,['NTID'=>$NTID]);
        return $id;
    }

    /**
     * 公告列表
     * @param $where
     * @param int $page
     * @param int $pagesize
     * @return array
     */
    function notice_list($where,$page=1,$pagesize=20){
        $info = mf::dbFactory("notice")->listinfo($where,"aid desc",$page,$pagesize);
        $count= mf::dbFactory("notice")->number;
        list($page, $pagenums, $pageStart, $pageCount) = getPage($page, $pagesize, $count);
        return [$info,$pagenums, $pageStart, $pageCount];
    }





}