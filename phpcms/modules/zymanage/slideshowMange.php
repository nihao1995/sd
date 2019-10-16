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
class slideshowMange extends admin
{
    function init()
    {
        include $this->admin_tpl('slideshow\slideshow');
    }






    //*************************************************************
    function editSlideshow()
    {
        if(!empty($_POST))
        {
            $neadArg = ['SSID'=>[true, 0], 'thumb'=>[false, 0], 'isshow'=>[true, 0]];
            $info = checkArg($neadArg, "POST");
            $item = new items("zyslideshow");
            $where["SSID"] = array_shift($info);
            $item->easySql->changepArg($info, $where);
        }
        else
        {
            $neadArg = ["SSID"=>[true, 0]];
            $info = checkArg($neadArg);
            $item = new items('zyslideshow');
            $data = $item->easySql->get_one($info);
            $upload_allowext = 'jpg|jpeg|gif|png|bmp';
            $isselectimage = '1';
            $images_width = '';
            $images_height = '';
            $watermark = '0';
            $authkey = upload_key("1,$upload_allowext,$isselectimage,$images_width,$images_height,$watermark");
            include $this->admin_tpl('slideshow\editSlideshow');
        }
    }
    function addSlideshow()
    {
        if(!empty($_POST))
        {
            $neadArg = ['thumb'=>[true, 0], 'isshow'=>[true, 0]];
            $info = checkArg($neadArg, "POST");
            $info["addtime"] = date("Y-m-d H:i:s",time());
            $item = new items("zyslideshow");
            $item->easySql->add($info);
        }
        else
        {
            $upload_allowext = 'jpg|jpeg|gif|png|bmp';
            $isselectimage = '1';
            $images_width = '';
            $images_height = '';
            $watermark = '0';
            $authkey = upload_key("1,$upload_allowext,$isselectimage,$images_width,$images_height,$watermark");
            include $this->admin_tpl('slideshow\addSlideshow');
        }
    }
    function getTypeData()
    {
        $item = new items('zyslideshow');
        $data = $item->easySql->select();
        returnAjaxData('1', '成功', $data);
    }
    function delType()
    {
        $neadArg = ["SSID"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $item = new items('zyslideshow');
        $item->easySql->del($info);
        returnAjaxData('1', '成功');
    }


}