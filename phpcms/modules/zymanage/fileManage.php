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
class fileManage extends admin
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
        include $this->admin_tpl('fileManage\fileManage');
    }
    function getData()
    {
        $neadArg = ["page"=>[true, 0], "titlename"=>[false, 0], "VFTID"=>[false, 0]];
        $info = checkArg($neadArg, "POST");
        $item = new items("zyfile");
        $page = array_shift($info);
        $info = array_merge($info, $this->getAdmInfo);
        list($data, $pagenums, $pageStart, $pageCount, $category) = $item->getFileInfo($info, $page);
        returnAjaxData('1', '成功', ['data'=>$data,'pagenums'=>$pagenums, 'pageStart'=>$pageStart, 'pageCount'=>$pageCount, "category"=>$category]);
    }
    function delData()
    {
        $neadArg = ["FID"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $items = new items('zyfile');
        $items->del($info);
        returnAjaxData('1', '删除成功');
    }

    function editFileManage()
    {
        if(!empty($_POST))
        {
            $neadArg = [ 'titlename'=>[true, 0], "VFTID"=>[true, 0],'fileAddr'=>[true, 0], "FID"=>[true, 0]];
            $info = checkArg($neadArg, "POST");
            $where["FID"] = array_pop($info);
            $info["fileAddr"] = json_encode($info["fileAddr"], JSON_UNESCAPED_UNICODE );
            $item = new items("zyfile");
            $item->easySql->changepArg($info, $where);
            returnAjaxData('1','修改成功');
        }
        else
        {
            $neadArg = ["FID"=>[true, 0]];
            $info = checkArg($neadArg);
            $item = new items('zyfile');
            $dataInfo = $item->easySql->get_one($info);
            $category = $item->easySql->get_one($info);
            include $this->admin_tpl('fileManage\fileManageEdit');
        }
    }
    function addFileManage()
    {
        if(!empty($_POST))
        {
            $neadArg = [ 'titlename'=>[true, 0], "VFTID"=>[true, 0],'fileAddr'=>[true, 0]];
            $info = checkArg($neadArg, "POST");
            $info["fileAddr"] = json_encode($info["fileAddr"], JSON_UNESCAPED_UNICODE );
            $info["addtime"] = date("Y-m-d H:i:s",time());
            $item = new items("zyfile");
            $info = array_merge($info, $this->adminInfo);
            $item->easySql->add($info);
            returnAjaxData('1','添加成功');
        }
        else
        {
            $allowuploadnum = '10';
            $alowuploadexts = '';
            $allowbrowser = 1;
            $authkeyss = upload_key("$allowuploadnum,$alowuploadexts,$allowbrowser");
            include $this->admin_tpl('fileManage\fileManageAdd');
        }
    }
    function upFile()
    {
        if (!empty ( $_FILES ['file'] ['name'] ))
            $tmp_file = $_FILES ['file'] ['tmp_name'];
        else
            returnAjaxData('-1','上传文件为空');
        $file_types = explode ( ".", $_FILES ['file'] ['name'] );
        $file_type = $file_types [count ( $file_types ) - 1];
        $basepath = str_replace( '\\' , '/' , realpath(dirname(__FILE__).'/../../../'));
        /*设置上传路径*/
        $time = date("Ymd", time());
        $savePath = $basepath.'/uploadfile/'.$time;
        if(!file_exists($savePath)){
            mkdir($savePath);
        }
        $file_name = $_FILES ['file'] ['name'];
        $str = date ( 'Ymdhis' ) + rand(1, 2000);
        $path = $savePath.'/'.$str.'.'.$file_type ;
        if(! copy ( $tmp_file, $path))
            returnAjaxData('-1', '上传失败');
        $uploadPath = APP_PATH.'uploadfile/'.$time.'/'.$str.'.'.$file_type;
        $returnData = ['name'=>$file_name, 'url'=>$uploadPath];
        returnAjaxData('1', 'success', $returnData);
    }
    function delID()
    {
        $neadArg = ["FID"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $exam = new items("zyfile");
        $exam->easySql->del_or($info);
        returnAjaxData('1', '成功');
    }

}