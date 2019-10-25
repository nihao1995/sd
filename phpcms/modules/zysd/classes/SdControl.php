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
        list($info, $count) = mf::dbFactory("notice")->moreTableSelect(array('zy_announce'=>array("*"), 'zy_notice_type'=>array('*')), array(["siteid","NTID"]), $where, ((string)($page-1)*$pagesize).",".$pagesize, "B1.addtime DESC,passed asc","1");
        list($page, $pagenums, $pageStart, $pageCount) = getPage($page, $pagesize, $count);
        return [$info,$pagenums, $pageStart, $pageCount];
    }

    /**
     * 添加公告
     * @param $data
     * @return mixed
     */
    function add_notice($data){
        if(empty($data)){
            returnAjaxData(-1,"缺少参数");
        }
        $card=mf::dbFactory('notice_type')->get_one(['notice_type_name'=>$data['notice_type_name']]);
        if($card){
            returnAjaxData(-2,"公告类型重复");
        }
        $id=mf::dbFactory('notice')->insert($data,true);
        return $id;
    }
    /**
     * 修改公告类型
     * @param $data
     * @param $where
     * @return mixed
     */
    function edit_notice($data,$where){
        if(empty($data)||empty($where)){
            returnAjaxData(-1,"缺少参数");
        }
        $id=mf::dbFactory('notice')->update($data,$where);
        return $id;
    }

    /**
     * 获取系统配置
     */
    function get_system_config(){
        $info = mf::dbFactory("zyfxconfig")->get_one();
        return $info;
    }

    /**
     * 更新系统配置
     * @param $data
     * @return mixed
     */
    function edit_system_config($data){
        if(empty($data)){
            returnAjaxData(-1,"缺少参数");
        }
        $info = mf::dbFactory("zyfxconfig")->update($data,1);
        return $info;
    }


}