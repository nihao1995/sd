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
class videoManage extends admin
{
    public $adminInfo = [];
    public $getAdmInfo = [];
    function __construct()
    {
        if($_SESSION["roleid"] != 1)
        {
            $this->adminInfo["roleid"] = $_SESSION["roleid"];
            $this->getAdmInfo["roleid"] = $_SESSION["roleid"];
            $this->adminInfo["adm_userid"] = $_SESSION["userid"];
        }
    }
    function init()
    {
        include $this->admin_tpl('videoManage\videoManage');
    }
    function getData()
    {
        $neadArg = ["page"=>[true, 0], "titlename"=>[false, 0], "VFTID"=>[false, 0]];
        $info = checkArg($neadArg, "POST");
        $item = new items("zyvideo");
        $page = array_shift($info);
        $info = array_merge($info, $this->getAdmInfo);
        list($data, $pagenums, $pageStart, $pageCount, $category) = $item->getVideoInfo($info, $page);
        returnAjaxData('1', '成功', ['data'=>$data,'pagenums'=>$pagenums, 'pageStart'=>$pageStart, 'pageCount'=>$pageCount, "category"=>$category]);
    }
    function delData()
    {
        $neadArg = ["VID"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $items = new items('zyvideo');
        $items->del($info);
        returnAjaxData('1', '删除成功');
    }

    function editVideoManage()
    {
        if(!empty($_POST))
        {
            $neadArg = ['VID'=>[true, 0], 'info'=>[true, 0], "thumb"=>[true, 0]];
            $info = checkArg($neadArg, "POST");
            $where["VID"] = array_shift($info);
            $info["info"]["photo"] = $info["thumb"];
            $item = new items("zyvideo");
            $item->easySql->changepArg($info["info"], $where);
        }
        else
        {
            $neadArg = ["VID"=>[true, 0]];
            $info = checkArg($neadArg);
            $item = new items('zyvideo');
            $dataInfo = $item->easySql->get_one($info);
            $category = (new items("zymanagetype"))->easySql->select(array("typeshow"=>'1'), "distinct `typename`, VFTID");
            $upload_allowext = 'jpg|jpeg|gif|png|bmp';
            $isselectimage = '1';
            $images_width = '';
            $images_height = '';
            $watermark = '0';
            $authkey = upload_key("1,$upload_allowext,$isselectimage,$images_width,$images_height,$watermark");
            include $this->admin_tpl('videoManage\videoManageEdit');
        }
    }
    function addVideoManage()
    {
        if(!empty($_POST))
        {
            $neadArg = [ 'info'=>[true, 0], "thumb"=>[false, 0]];
            $info = checkArg($neadArg, "POST");
            $info["info"]["photo"] = $info["thumb"];
            $info["info"]["addtime"] = date("Y-m-d H:i:s",time());
            $info["info"] = array_merge($info["info"], $this->adminInfo);
            $item = new items("zyvideo");
            $item->easySql->add($info["info"]);
        }
        else
        {
            $category = (new items("zymanagetype"))->easySql->select(array("typeshow"=>'1'), "distinct `typename`, VFTID");
            $upload_allowext = 'jpg|jpeg|gif|png|bmp';
            $isselectimage = '1';
            $images_width = '';
            $images_height = '';
            $watermark = '0';
            $authkey = upload_key("1,$upload_allowext,$isselectimage,$images_width,$images_height,$watermark");
            include $this->admin_tpl('videoManage\videoManageAdd');
        }
    }
    function delID()
    {
        $neadArg = ["VID"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $exam = new items("zyvideo");
        $exam->easySql->del_or($info);
        returnAjaxData('1', '成功');
    }


}