<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);	//加载应用类方法
pc_base::load_sys_class('form', 0, 0);
pc_base::load_app_func('global');
pc_base::load_sys_class('Res', '', 0);
use zymanage\classes\items as items;
use zytestquestions\classes\items as testItems;
/**
 * Created by PhpStorm.
 * User: 徐强
 * Date: 2019/6/27
 * Time: 14:22
 */
class studyPlan extends admin
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
        include $this->admin_tpl('studyPlan\studyPlan');
    }
    function getData()
    {
        $neadArg = ["page"=>[true, 0], "titlename"=>[false, 0], "VFTID"=>[false, 0]];
        $info = checkArg($neadArg, "POST");
        $item = new items("zystudyplan");
        $page = array_shift($info);
        $info = array_merge($info, $this->getAdmInfo);
        list($data, $pagenums, $pageStart, $pageCount, $category) = $item->getFileInfo($info, $page);
        $fileData = new items("zyfile");
        $videoData = new items("zyvideo");
        foreach ($data as $key=>$value)
        {
            if(!empty($value["FID"]))
            {
                $data[$key]["FID"] = json_decode($value["FID"], true);
                $data[$key]["FID"] = $fileData->easySql->select_or(array("FID"=>$data[$key]["FID"]));

            }
            if(!empty($value["VID"]))
            {
                $data[$key]["VID"] = json_decode($value["VID"], true);
                $data[$key]["VID"] = $videoData->easySql->select_or(array("VID"=>$data[$key]["VID"]));
            }
            if(isset($value["SCID"]))  $data[$key]["SCID"] = json_decode($value["SCID"], true );
            if(isset($value["RCID"]))  $data[$key]["RCID"] = json_decode($value["RCID"], true );
            if(isset($value["MCID"]))  $data[$key]["MCID"] = json_decode($value["MCID"], true );
            if(isset($value["TFCID"]))  $data[$key]["TFCID"] = json_decode($value["TFCID"], true );
        }
        returnAjaxData('1', '成功', ['data'=>$data,'pagenums'=>$pagenums, 'pageStart'=>$pageStart, 'pageCount'=>$pageCount, "category"=>$category]);
    }
    function delData()
    {
        $neadArg = ["SPID"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $items = new items('zystudyplan');
        $items->del($info);
        returnAjaxData('1', '删除成功');
    }

    function editSPManage()
    {
        if(!empty($_POST))
        {
            $neadArg = ["titlename"=>[true, 0], "VFTID"=>[true, 0], "iselite"=>[false, 1], "FID"=>[false, 0], "VID"=>[false, 0],"SCID"=>[false, 0],"MCID"=>[false, 0],"RCID"=>[false, 0],'TFCID'=>[false, 0],'category'=>[true, 0], "SPID"=>[true, 0]];
            $info = checkArg($neadArg, "POST");
            $where["SPID"] = array_pop($info);
            if(isset($info["FID"]))  $info["FID"] = json_encode($info["FID"], JSON_UNESCAPED_UNICODE ); else $info["FID"] =  ''  ;
            if(isset($info["VID"]))  $info["VID"] = json_encode($info["VID"], JSON_UNESCAPED_UNICODE );else $info["VID"] = '' ;
            if(isset($info["SCID"]))  $info["SCID"] = json_encode($info["SCID"], JSON_UNESCAPED_UNICODE ); else $info["SCID"] = '';
            if(isset($info["RCID"]))  $info["RCID"] = json_encode($info["RCID"], JSON_UNESCAPED_UNICODE );else $info["RCID"] = '';
            if(isset($info["MCID"]))  $info["MCID"] = json_encode($info["MCID"], JSON_UNESCAPED_UNICODE );else $info["MCID"] = '';
            if(isset($info["TFCID"]))  $info["TFCID"] = json_encode($info["TFCID"], JSON_UNESCAPED_UNICODE );else $info["TFCID"] = '';
            $item = new items("zystudyplan");
            $item->easySql->changepArg($info, $where);
            returnAjaxData('1','修改成功');
        }
        else
        {
            $neadArg = ["SPID"=>[true, 0]];
            $info = checkArg($neadArg);
            $item = new items('zystudyplan');
            $dataInfo = $item->easySql->get_one($info);
            include $this->admin_tpl('studyPlan\studyPlanEdit');
        }
    }
    function addStudyPlan()
    {
        if(!empty($_POST))
        {
            $neadArg = ["titlename"=>[true, 0], "VFTID"=>[true, 0], "FID"=>[false, 0], "VID"=>[false, 0], "iselite"=>[true, 1],"SCID"=>[false, 0],"MCID"=>[false, 0],"RCID"=>[false, 0],'TFCID'=>[false, 0],'category'=>[true, 0]];
            $info = checkArg($neadArg, "POST");
            $info["addtime"] = date("Y-m-d H:i:s",time());
            if(isset($info["FID"]))  $info["FID"] = json_encode($info["FID"], JSON_UNESCAPED_UNICODE );
            if(isset($info["VID"]))  $info["VID"] = json_encode($info["VID"], JSON_UNESCAPED_UNICODE );
            if(isset($info["SCID"]))  $info["SCID"] = json_encode($info["SCID"], JSON_UNESCAPED_UNICODE );
            if(isset($info["MCID"]))  $info["MCID"] = json_encode($info["MCID"], JSON_UNESCAPED_UNICODE );
            if(isset($info["RCID"]))  $info["RCID"] = json_encode($info["RCID"], JSON_UNESCAPED_UNICODE );
            if(isset($info["TFCID"]))  $info["TFCID"] = json_encode($info["TFCID"], JSON_UNESCAPED_UNICODE );
            $info = array_merge($info, $this->adminInfo);
            $item = new items("zystudyplan");
            $item->easySql->add($info);
            returnAjaxData('1','添加成功');
        }
        else
        {
            include $this->admin_tpl('studyPlan\studyPlanAdd');
        }
    }
    function getFileAndVideo()
    {
        $neadArg = ["VFTID"=>[true, 0], "category"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $where["category"] = array_pop($info);
        $info = array_merge($info, $this->getAdmInfo);
        $videoItems = new items("zyvideo");
        $videoData = $videoItems->easySql->select($info);
        $fileItems = new items("zyfile");
        $fileData = $fileItems->easySql->select($info);
        $choice = new testItems("zysinglechoice");
        list($singlechoice, $multiplechoice, $trueorfalsechoice, $rankchoice) = $choice->getCategoryItems($where);
        returnAjaxData("1", "成功", ["videoData"=>$videoData, "fileData"=>$fileData, "singlechoice"=>$singlechoice, "multiplechoice"=>$multiplechoice, "trueorfalsechoice"=>$trueorfalsechoice, "rankchoice"=>$rankchoice]);
    }
    function delID()
    {
        $neadArg = ["SPID"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $exam = new items("zystudyplan");
        $exam->easySql->del_or($info);
        returnAjaxData('1', '成功');
    }




    //*************************************************************type
    function manageType()
    {
        include $this->admin_tpl('manageType\manageType');
    }
    function editManageType()
    {
        if(!empty($_POST))
        {
            $neadArg = ['VFTID'=>[true, 0], 'typename'=>[true, 0], 'typeshow'=>[true, 0], "sort"=>[true, 1],"thumb"=>[false, 0]];
            $info = checkArg($neadArg, "POST");
            $item = new items("zymanagetype");
            $where["VFTID"] = array_shift($info);
            $item->easySql->changepArg($info, $where);
        }
        else
        {
            $neadArg = ["VFTID"=>[true, 0]];
            $info = checkArg($neadArg);
            $item = new items('zymanagetype');
            $data = $item->easySql->get_one($info);
            $upload_allowext = 'jpg|jpeg|gif|png|bmp';
            $isselectimage = '1';
            $images_width = '';
            $images_height = '';
            $watermark = '0';
            $authkey = upload_key("1,$upload_allowext,$isselectimage,$images_width,$images_height,$watermark");
            include $this->admin_tpl('manageType\editManageType');
        }
    }
    function addManageType()
    {
        if(!empty($_POST))
        {
            $neadArg = ['typename'=>[true, 0], 'typeshow'=>[true, 0],"sort"=>[true, 1] ,"thumb"=>[false, 0]];
            $info = checkArg($neadArg, "POST");
            $item = new items("zymanagetype");
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
            include $this->admin_tpl('manageType\addManageType');
        }
    }
    function getTypeData()
    {
        $item = new items('zymanagetype');
        $data = $item->easySql->select("1", "*", '', "sort ASC");
        returnAjaxData('1', '成功', $data);
    }
    function delType()
    {
        $neadArg = ["VFTID"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $item = new items('zymanagetype');
        $item->easySql->del($info);
        returnAjaxData('1', '成功');
    }
    function editManageAjax()
    {
        $neadArg = ["typename"=>[true, 0]];
        $info = checkArg($neadArg);
        $item = new items("zymanagetype");
        $data = $item->easySql->get_one($info);
        if(empty($data))
            exit('1');
        else
            exit('0');
    }
}