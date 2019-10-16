<?php
/**
 * Created by PhpStorm.
 * User: 徐强
 * Date: 2019/7/10
 * Time: 15:21
 */
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_func('global');
pc_base::load_sys_class('form', '', 0);
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('Res', '', 0);
use zymanage\classes\items as items;

class videoStudyApi
{
    function getVideoType()
    {
        $items = new items("zyvideomanagetype");
        $data = $items->easySql->select(['typeshow'=>'1']);
        returnAjaxData('1', '查询成功',$data);
    }
    function getVideo()
    {
        $neadArg = ["VTID"=>[true, 0], "page"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $page = array_pop($info);
        $items = new items("zyvideo");
        list($data, $pagenums, $pageStart, $pageCount, $category) = $items->getVideoInfo($info, $page);
        returnAjaxData('1', "成功",['data'=>$data, 'pageCount'=>$pageCount]);
    }
}