<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);	//加载应用类方法
pc_base::load_sys_class('form', 0, 0);
pc_base::load_app_func('global');
pc_base::load_sys_class('Res', '', 0);
use zymanage\classes\items as items;
/**
 * Created by PhpStorm.
 * User: 徐强
 * Date: 2019/6/27
 * Time: 14:22
 */
class pkMatching extends admin
{
    function pkMatchingRecord()
    {
        include $this->admin_tpl('pkMatching\pkMatchingRecord');
    }
    function pkMatchingConfig()
    {
        include $this->admin_tpl('pkMatching\pkMatchingConfig');
    }
    function getPKData()
    {
        $neadArg = ["page"=>[true, 1], "nickname"=>[false, 0]];
        $info = checkArg($neadArg, "POST");
        $page = array_shift($info);
        $pkMatch = new items("zypkrecord");
        list($data, $pagenums, $pageStart, $pageCount) = $pkMatch->getPKData($page, $info);
        returnAjaxData('1',"成功",['data'=>$data,'pagenums'=>$pagenums, 'pageStart'=>$pageStart, 'pageCount'=>$pageCount]);
    }

    function del()
    {
        $neadArg = ["PKRID"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $item = new items('zypkrecord');
        $item->easySql->del($info);
        returnAjaxData('1', '成功');
    }

    function getConfig()
    {
        $pkConfig = new items("zypkconfig");
        $pkConfigInfo = $pkConfig->easySql->get_one(array("PKCID"=>1));
        $pkConfigInfo["pkTime"] = date("H:i:s",strtotime('today') + $pkConfigInfo["pkTime"]);
        returnAjaxData('1',"成功", $pkConfigInfo);
    }
    function uploadConfig()
    {
        $neadArg = ["singleChoiceCount"=>[true, 0], "multipleChoiceCount"=>[true, 0], "trueOrFalseChoiceCount"=>[true, 0], "pkTime"=>[true, 0], "rankChoiceCount"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $info["pkTime"] = strtotime($info["pkTime"]) - strtotime('today');
        $pkConfig = new items("zypkconfig");
        $pkConfig->easySql->changepArg($info, array("PKCID"=>1));
        returnAjaxData('1','修改成功', $info);
    }
}