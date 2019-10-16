<?php
/**
 * Created by PhpStorm.
 * User: 徐强
 * Date: 2019/7/12
 * Time: 8:41
 */
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_func('global');
pc_base::load_sys_class('form', '', 0);
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('Res', '', 0);
use zymanage\classes\items as items;
use zytestquestions\classes\items as questionItems;

class manageApi
{
    public $userid = '';
    function __construct()
    {
        $this->userid = param::get_cookie('_userid');
//        $this->userid = 1;
        $member = new items("member");
        $info = $member->easySql->get_one(["userid"=>$this->userid], "cookie");
        $s = pc_base::load_config('system','cookie_pre')."_userid";
        if(empty($this->userid) )
            returnAjaxData("-201","请登录");
        elseif( $info["cookie"] != $_COOKIE[$s])
        {
            param::set_cookie('auth', '');
            param::set_cookie('_userid', '');
            param::set_cookie('_username', '');
            param::set_cookie('_groupid', '');
            param::set_cookie('_nickname', '');
            param::set_cookie('cookietime', '');
            returnAjaxData("-201","请重新登录");
        }
    }
    function getSlideshow()
    {
        $items = new items("zyslideshow");
        $data = $items->easySql->select(array("isshow"=>'1'), '*', '10', "addtime DESC");
        $studyItem = new items("zymanagetype");
        $category = $studyItem->easySql->select(array("typeshow"=>'1'), "distinct `typename`, VFTID, thumb", '',"sort ASC");
        returnAjaxData('1', '成功', ["slideshow"=>$data, "category"=>$category]);
    }
    function getElitePlan()
    {
        $neadArg = ["page"=>[true, 0], "titlename"=>[false, 0]];
        $info = checkArg($neadArg, "POST");
        $item = new items("zystudyplan");
        $page = array_shift($info);
        $info["iselite"] = 1;
        list($data, $pagenums, $pageStart, $pageCount, $category) = $item->getFileInfo($info, $page);
        $fileData = new items("zyfile");
        $videoData = new items("zyvideo");
        foreach ($data as $key=>$value)
        {
            if(!empty($value["FID"]))
            {
                $data[$key]["FID"] = json_decode($value["FID"], true);
                $data[$key]["FID"] = $fileData->easySql->select_or(array("FID"=>$data[$key]["FID"]));
                foreach($data[$key]["FID"] as $k=>$v)
                {
                    $data[$key]["FID"][$k]["fileAddr"] = json_decode($v["fileAddr"], true);
                }
            }
            if(!empty($value["VID"]))
            {
                $data[$key]["VID"] = json_decode($value["VID"], true);
                $data[$key]["VID"] = $videoData->easySql->select_or(array("VID"=>$data[$key]["VID"]));
            }

        }
        returnAjaxData('1', '成功', ['data'=>$data,'pagenums'=>$pagenums, 'pageStart'=>$pageStart, 'pageCount'=>$pageCount]);
    }
    function getStudyPlan()
    {
        $neadArg = ["page"=>[true, 0], "VFTID"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $page = array_shift($info);
        $item = new items("zystudyplan");
        list($data, $pagenums, $pageStart, $pageCount, $category) = $item->getFileInfo($info, $page);
        $fileData = new items("zyfile");
        $videoData = new items("zyvideo");
        foreach ($data as $key=>$value)
        {
            if(!empty($value["FID"]))
            {
                $data[$key]["FID"] = json_decode($value["FID"], true);
                $data[$key]["FID"] = $fileData->easySql->select_or(array("FID"=>$data[$key]["FID"]));
                foreach($data[$key]["FID"] as $k=>$v)
                {
                    $data[$key]["FID"][$k]["fileAddr"] = json_decode($v["fileAddr"], true);
                }
            }
            if(!empty($value["VID"]))
            {
                $data[$key]["VID"] = json_decode($value["VID"], true);
                $data[$key]["VID"] = $videoData->easySql->select_or(array("VID"=>$data[$key]["VID"]));
            }
        }
        returnAjaxData('1', '成功', ['data'=>$data,'pagenums'=>$pagenums, 'pageStart'=>$pageStart, 'pageCount'=>$pageCount, "category"=>$category]);
    }
    function getChoice()
    {
        $neadArg = ["SPID"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $items = new items("zystudyplan");
        $spl = $items->easySql->get_one($info);
        $choiceItems = new questionItems("zysinglechoice");
        $singlechoice = empty($spl["SCID"])?[]:$choiceItems->easySql->select_or(array("SCID"=>json_decode($spl["SCID"], true)), "SCID,itemname,options,answer,provenance");
        $multiplechoice = empty($spl["MCID"])?[]:(new questionItems("zymultiplechoice"))->easySql->select_or(array("MCID"=>json_decode($spl["MCID"], true)),"MCID,itemname,options,answer,provenance");
        $rankchoice = empty($spl["RCID"])?[]:(new questionItems("zyrankchoice"))->easySql->select_or(array("RCID"=>json_decode($spl["RCID"], true)),"RCID,itemname,options,answer,provenance");
        $trueorfalsechoice = empty($spl["TFCID"])?[]:(new questionItems("zytrueorfalsechoice"))->easySql->select_or(array("TFCID"=>json_decode($spl["TFCID"], true)),"TFCID,itemname,answer,provenance");
        returnAjaxData("1", "成功", ["singlechoice"=>$singlechoice, "multiplechoice"=>$multiplechoice, "trueorfalsechoice"=>$trueorfalsechoice, "rankchoice"=>$rankchoice]);
    }

    function getIntegralInfo()
    {
        $info["userid"] = $this->userid;
        $integral = new items("zyintegralinfo");
        $integralInfo = $integral->easySql->select($info, "*", '30', "addtime DESC");
        $member = new items("member");
        $userIntegral = $member->easySql->get_one($info, "integral");
        returnAjaxData('1',"成功", ["data"=>$integralInfo, "integral"=>$userIntegral]);
    }
    function addStudyPlan()
    {
        $neadArg = [ "SPID"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $info["userid"] = $this->userid;
        $member = new questionItems("zymemberinfo");
        $data = $member->easySql->get_one(["userid"=>$info["userid"]], "userid,studyplan");
        if(empty($data))
            $data = $member->insertMemberInfo($member, $info["userid"]);
        $p = json_decode($data["studyplan"], true);
        if(isset($p[$info["SPID"]]))
            returnAjaxData('-1', "以添加");
        else
            $p[$info["SPID"]] = ["file"=>0, "video"=>0];
        $member->easySql->changepArg(["studyplan"=>json_encode($p)], ["userid"=>$info["userid"]]);
        returnAjaxData('1', "添加成功");
    }
    function studyPlan()
    {
        $neadArg = [ "SPID"=>[true, 0], "type"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $info["userid"] = $this->userid;
        $member = new questionItems("zymemberinfo");
        $data = $member->easySql->get_one(["userid"=>$info["userid"]], "userid, studyplan");
        if(empty($data))
            $data = $member->insertMemberInfo($member, $info["userid"]);
        $p = json_decode($data["studyplan"], true);
        if($info["type"] != "video" && $info["type"] != "file")
            returnAjaxData('-1', "type参数错误");
        if(!isset($p[$info["SPID"]]))
            returnAjaxData("-1", "传入参数错误");
        $p[$info["SPID"]][$info["type"]] = 1;
        $member->easySql->changepArg(["studyplan"=>json_encode($p)], ["userid"=>$info["userid"]]);
        returnAjaxData('1', "添加成功");
    }
    function getSaveStudyPlan()//学习进度
    {
        $info["userid"] = $this->userid;
        $member = new questionItems("zymemberinfo");
        $data = $member->easySql->get_one(["userid"=>$info["userid"]], "userid,studyplan");
        if(empty($data))
            $data = $member->insertMemberInfo($member, $info["userid"]);
        $p = json_decode($data["studyplan"], true);
        $fileData = new items("zyfile");
        $videoData = new items("zyvideo");
        $item = new items("zystudyplan");
        foreach ($p as $key=>$f)
        {
            $value = $item->easySql->get_one(array("SPID"=>$key));
            if(!$value)
            {
                unset($p[$key]);
                continue;
            }
            if(!empty($value["FID"]))
            {
                $p[$key]["FID"] = json_decode($value["FID"], true);
                $p[$key]["FID"] = $fileData->easySql->select_or(array("FID"=>$p[$key]["FID"]));
                foreach($p[$key]["FID"] as $k=>$v)
                {
                    $p[$key]["FID"][$k]["fileAddr"] = json_decode($v["fileAddr"], true);
                }
            }
            if(!empty($value["VID"]))
            {
                $p[$key]["VID"] = json_decode($value["VID"], true);
                $p[$key]["VID"] = $videoData->easySql->select_or(array("VID"=>$p[$key]["VID"]));
            }
            $p[$key]["titlename"] = $value["titlename"];
        }
        returnAjaxData("1", "成功", $p);
    }
    //************************************************规章管理

    function getRules()
    {
        $neadArg = ["page"=>[true, 1], "type"=>[true, 1], "titlename"=>[false, 0]];
        $info = checkArg($neadArg, "POST");
        $page = array_shift($info);
        $str = '';
        $type = array_shift($info);
        $content = "*";
        switch($type)
        {
            case 1:$str = "zyrules";$content = "RID, addtime, titlename, abstract"; break;
            case 2:$str = "zyrulesfile"; break;
            default :returnAjaxData("-1", "参数错误");
        }
        $item = new items($str);
        list($data, $pagenums, $pageStart, $pageCount) = $item->getRulesFileInfo($info, $page, $content);
        returnAjaxData('1', '成功', ['data'=>$data,'pagenums'=>$pagenums, 'pageStart'=>$pageStart, 'pageCount'=>$pageCount]);
    }
    function getRulesContent()
    {
        $neadArg = ["RID"=>[true, 1]];
        $info = checkArg($neadArg, "POST");
        $item = new items("zyrules");
        $data = $item->easySql->get_one($info);
        returnAjaxData('1', "成功", $data);
    }



}