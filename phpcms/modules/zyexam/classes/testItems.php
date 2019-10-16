<?php
/**
 * Created by PhpStorm.
 * User: 徐强
 * Date: 2019/6/29
 * Time: 10:19
 */

namespace zyexam\classes;
use zyexam\classes\easySql as easySql;
use zyexam\classes\modelFactory as mf;

class testItems
{
    public $DB;
    public $easySql;
    public $pagesize = 7;
    public $type;
    public $workType = ['glry', 'khfwy', 'kyy', 'lcy','kyzby', 'spy','jhy','spzby', 'lcz', 'lczby','xly','xlzby', 'kfzky', 'gsy','ccz'];
    function __construct($type)
    {
        $this->type = $type;
        $this->DB = mf::Create()->getModel($type);
        $this->easySql = new easySql($type);
    }
    function getCategory()
    {
        $sql = 'select distinct t.`category` from(select  `category` from zy_zymultiplechoice UNION  select `category` from zy_zysinglechoice UNION  select  `category` from zy_zytrueorfalsechoice)t';
        $data = $this->DB->spcSQL($sql, 1, 1);
        return $data;
    }
    function getCategoryItems($where)
    {
        $where = returnWhereSQL($where, '');
        $sql = 'select * from zy_zymultiplechoice where '.$where;
        $data2 = $this->DB->spcSQL($sql, 1, 1);
        $sql = 'select * from zy_zysinglechoice where '.$where;
        $data1 = $this->DB->spcSQL($sql, 1, 1);
        $sql = 'select * from zy_zytrueorfalsechoice where '.$where;
        $data3 = $this->DB->spcSQL($sql, 1, 1);
        $sql = 'select * from zy_zyrankchoice where '.$where;
        $data4 = $this->DB->spcSQL($sql, 1, 1);
        return array($data1, $data2, $data3, $data4);
    }
    function merageItems($data1, $data2, $data3, $data4, $userid)
    {
        if($data1 == null)
            $data1 = [];
        if($data2 == null)
            $data2 = [];
        if($data3 == null)
            $data3 = [];
        if($data4 == null)
            $data4 = [];
        $data = array_merge($data1, $data2, $data3, $data4);
        shuffle($data);
        $userInfo = (new easySql("zymemberinfo"))->get_one(array("userid"=>$userid));//*************************************************
        foreach ($userInfo as $key=>$value)
        {
            if(strpos($key,"Error") || strpos($key,"Collect"))
                $userInfo[$key] = $this->stringTOArray($userInfo[$key]);
        }
        return array($data,$userInfo);
    }


    function getInfo($where,$page = 1)
    {
        if(isset($where["DBname"]))
        {
            $DBname = array_pop($where);
            foreach ($DBname as $key=>$value)
                $where[$value] = 1;
        }
        $idName = '';
        switch ($this->type)
        {
            case "zymultiplechoice":$idName = 'MCID';break;
            case "zysinglechoice":$idName = 'SCID';break;
            case "zytrueorfalsechoice":$idName = 'TFCID';break;
            case "zyrankchoice":$idName = 'RCID';break;
            case "zychoiceerror":$idName = 'CEID';break;
//            case "zymultiplechoice":$idName = 'MCID';break;
//            case "zymultiplechoice":$idName = 'MCID';break;
        }
        if(empty($idName))
            Error('type类型错误');
        $where = returnWhereSQL($where);
        list($info, $count) = $this->DB->moreTableSelect(array('zy_'.$this->type=>array("*")), array(), $where, ((string)($page-1)*$this->pagesize).",".$this->pagesize, "B1.".$idName." DESC","1");
        //$info["options"] = json_decode($info['options'], true);
        list($page, $pagenums, $pageStart, $pageCount) = getPage($page, $this->pagesize, $count);
        $category = $this->easySql->select("1", "distinct `category`");
        //$category = array_values($category);
        $category = array_map(function($k){return $k["category"];}, $category);
        return array($info, $pagenums, $pageStart, $pageCount, $category);
    }
    function getCommentInfo($where, $page = 1)
    {
        $where = returnWhereSQL($where);
        switch ($this->type)
        {
            case "zymultiplechoicecomment":$idName = 'MCCID';break;
            case "zysinglechoicecomment":$idName = 'SCCID';break;
            case "zytrueorfalsechoicecomment":$idName = 'TFCCID';break;
            case "zyrankchoicecomment":$idName = 'RCCID';break;
//            case "zymultiplechoice":$idName = 'MCID';break;
        }
        list($info, $count) = $this->DB->moreTableSelect(array('zy_'.$this->type=>array("*"), 'zy_member'=>array("nickname, headimgurl")), array("userid"), $where, ((string)($page-1)*$this->pagesize).",".$this->pagesize, "B1.".$idName." DESC","1");
        list($page, $pagenums, $pageStart, $pageCount) = getPage($page, $this->pagesize, $count);
        return array($info, $pagenums, $pageStart, $pageCount);
    }
    function GZ($userid)
    {
        $item = new easySql("member");
        $itemData = $item->get_one(["userid"=>$userid], "work_type");
        if(empty($itemData))
            returnAjaxData("-1", "没有找到该用户");
        return $itemData["work_type"];
    }
    function getAllInfo($where, $userid=1)
    {
        $where[$this->GZ($userid)] = 1;
        if(isset($where["DBname"]))
        {
            $DBname = array_pop($where);
            foreach ($DBname as $key=>$value)
                $where[$value] = 1;
        }
        $idName = '';
        $fieldName = '';
        switch ($this->type)
        {
            case "zymultiplechoice":$idName = 'MCID';$fieldName = "multiplechoice"; break;
            case "zysinglechoice":$idName = 'SCID';$fieldName = "singlechoice"; break;
            case "zytrueorfalsechoice":$idName = 'TFCID';$fieldName = "trueorfalsechoice"; break;
            case "zyrankchoice":$idName = 'RCID';$fieldName = "rankchoice";break;
//            case "zymultiplechoice":$idName = 'MCID';break;
//            case "zymultiplechoice":$idName = 'MCID';break;
        }
        if(empty($idName))
            returnAjaxData('-1', 'type类型错误');
        $where = returnWhereSQL($where);
        //$where .= " AND SCID <= 1";
        list($info, $count) = $this->DB->moreTableSelect(array('zy_'.$this->type=>array("*")), array(), $where, '', "B1.".$idName." DESC","1");
        $category = $this->easySql->select("1", "distinct `category`");
        //$category = array_values($category);
        $memberInfo = new items("zymemberinfo");
        $userInfo = $memberInfo->easySql->get_one(array("userid"=>$userid), $fieldName.",".$fieldName.'Error'.",".$fieldName.'Collect, userid');
        if(empty($userInfo))
            $userInfo = $this->insertMemberInfo($memberInfo, $userid);
        $userInfo[$fieldName.'Error'] = $this->stringTOArray($userInfo[$fieldName.'Error']);
        $userInfo[$fieldName.'Collect'] = $this->stringTOArray($userInfo[$fieldName.'Collect']);
        $category = array_map(function($k){return $k["category"];}, $category);
        return array($info, $category, $userInfo);
    }
    function getErrorInfo($where, $page=1)
    {
        if(isset($where["DBname"]))
        {
            $DBname = array_pop($where);
            foreach ($DBname as $key=>$value)
                $where[$value] = 1;
        }
        $idName = '';
        switch ($this->type)
        {
            case "zychoiceerror":$idName = 'CEID';break;
            case "zyuserchoice":$idName = 'UCID';break;
        }
        $where = returnWhereSQL($where);
        list($info, $count) = $this->DB->moreTableSelect(array('zy_'.$this->type=>array("*")), array(), $where, ((string)($page-1)*$this->pagesize).",".$this->pagesize, "B1.".$idName." DESC","1");
        //$info["options"] = json_decode($info['options'], true);
        list($page, $pagenums, $pageStart, $pageCount) = getPage($page, $this->pagesize, $count);
        return array($info, $pagenums, $pageStart, $pageCount);
    }





    function insertMemberInfo($memberInfo,$userid)
    {
        $memberInfo->easySql->add(array("userid"=>$userid, "singlechoiceError"=>',',"multiplechoiceError"=>',',"trueorfalsechoiceError"=>',',"rankchoiceError"=>',',"singlechoiceCollect"=>',',"multiplechoiceCollect"=>',',"trueorfalsechoiceCollect"=>',',"rankchoiceCollect"=>','));
        return $memberInfo->easySql->get_one(array("userid"=>$userid));
    }

    function stringTOArray($info)
    {
        $returnData = [];
        if(!empty($info))
        {
            $returnData = explode(',', $info);
            array_pop($returnData);
            array_shift($returnData);
        }
        return $returnData;
    }

    function getWorkType($info)
    {
        $ret = ['1'];
        foreach ($info as $k=>$v)
        {
            if($v == '1')
            {
                if(in_array($k, $this->workType))
                {
                    $ret[] = $k;
                }
            }
        }
        return $ret;
    }
    function del($where)
    {
        $this->easySql->del($where);
    }

    //****************************************************************pk
    function pkQuestion($info)
    {
        $where = returnWhereSQL($info, "");
        $pkConfig = new easySql("zypkconfig");
        $pkconfigInfo = $pkConfig->get_one(array("PKCID"=>1));
        $singleChoice = new easySql("zysinglechoice");
        $multiplechoice = new easySql("zymultiplechoice");
        $trueorfalsechoice = new easySql("zytrueorfalsechoice");
        $rankchoice = new easySql("zyrankchoice");
        $singleChoiceData = $singleChoice->select($where, "SCID,itemname,options,answer, choiceType, videourl,photourl", $pkconfigInfo["singleChoiceCount"], "RAND()");
        $multiplechoiceData = $multiplechoice->select($where, "MCID,itemname,options,answer, choiceType, videourl,photourl", $pkconfigInfo["multipleChoiceCount"], "RAND()");
        $trueorfalsechoiceData = $trueorfalsechoice->select($where, "TFCID,itemname,answer, choiceType, videourl,photourl", $pkconfigInfo["trueOrFalseChoiceCount"], "RAND()");
        $rankchoiceData = $rankchoice->select($where, "RCID,itemname,answer,options, choiceType, videourl,photourl", $pkconfigInfo["rankChoiceCount"], "RAND()");
        list($data, $b) = $this->merageItems($singleChoiceData, $multiplechoiceData, $trueorfalsechoiceData, $rankchoiceData, 1);
        return array($data,$pkconfigInfo["pkTime"]);

    }
}