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
use zyexam\classes\items as items;
use zyexam\classes\testItems as choiceItems;

class examApi
{
    public $userid = '';
    public $ff = ["SCID"=>"zysinglechoice", "MCID"=>"zymultiplechoice", "TFCID"=>"zytrueorfalsechoice", "RCID"=>"zyrankchoice"];

    function __construct()
    {
        $this->userid = param::get_cookie('_userid');
        if(empty($this->userid))
            returnAjaxData("-200","请登录");
    }
    function haveExam() //判断是否有考生
    {
        $userid = $this->userid;
        $items = new items("zyexam");
        $time = time();
        $exam = $items->easySql->select("`timestampEnd` >".$time);
        $hasExam =[];
        foreach ($exam as $key=>$value)
        {
            if(preg_match("\"".$userid."\"", $value["member"]))
                $hasExam[] = $value;
        }
        returnAjaxData('1',"成功", $hasExam);
    }
    function finishExam() //考生考完了试
    {
        $userid = $this->userid;
        $items = new items("zyexam");
        $time = time();
        $exam = $items->easySql->select("`finishMember` like '%\"".$userid."\"%'","*", "","addtime Desc");
        returnAjaxData('1',"成功", $exam);
    }

    function getAllResult()
    {
        $neadArg = ["EID"=>[true, 1]];
        $info = checkArg($neadArg, "POST");
        $exam = new items("zyexamresults");
        list($data,$count) = $exam->getExamGrade($info);
        returnAjaxData('1', "成功", $data);
    }
    public function getChoice($where, $str='') //前台获取考题
    {
        $items = new items("zyexam");
        $choiceItems = new choiceItems("zysinglechoice");
        $exam = $items->easySql->get_one($where);
        $userid =  $this->userid;
        if($exam == null)
            returnAjaxData("-1", "没有找到考试信息");
        else if($exam["timestampStart"] > time())
            returnAjaxData("-1", "考试未开始");
        else if($exam["timestampEnd"] < time())
            returnAjaxData("-1", "考试以结束");
        else if(!preg_match("\"".$userid."\"", $exam["member"]))
            returnAjaxData("-1", "你不属于这场考试的成员");
        $examTime = strtotime($exam["examTime"]) - strtotime('today');
        $singlechoice = empty($exam["SCID"])?[]:$choiceItems->easySql->select_or(array("SCID"=>json_decode($exam["SCID"], true)), "SCID,itemname,options,choiceType,videourl,photourl".$str);
        $multiplechoice = empty($exam["MCID"])?[]:(new choiceItems("zymultiplechoice"))->easySql->select_or(array("MCID"=>json_decode($exam["MCID"], true)),"MCID,itemname,options,choiceType,videourl,photourl".$str);
        $rankchoice = empty($exam["RCID"])?[]:(new choiceItems("zyrankchoice"))->easySql->select_or(array("RCID"=>json_decode($exam["RCID"], true)),"RCID,itemname,options,choiceType,videourl,photourl".$str);
        $trueorfalsechoice = empty($exam["TFCID"])?[]:(new choiceItems("zytrueorfalsechoice"))->easySql->select_or(array("TFCID"=>json_decode($exam["TFCID"], true)),"TFCID,itemname,choiceType,videourl,photourl".$str);
        list($data,$userInfo) = $choiceItems->merageItems($singlechoice, $multiplechoice, $trueorfalsechoice, $rankchoice, $userid);
        return array($data,$userInfo, $examTime);
    }
    function takeExam()
    {
        $neadArg = ["EID"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        list($data,$userInfo, $examTime)  = $this->getChoice($info);
        returnAjaxData('1', '成功', ["data"=>$data, "examTime"=>$examTime]);
    }

    function getExamErrorChoice()
    {
        $neadArg = ["EID"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $items = new items("zyexamresults");
        $info["userid"] = $this->userid;
        $result = $items->easySql->get_one($info, "userid, ErrorID");
        if(empty($result))
            returnAjaxData("-1", "未查到考试信息");
        $ErrorChoice = json_decode($result["ErrorID"] , true);
        $numPre = '/[0-9]+/';
        $choice = [];
        foreach ($ErrorChoice as $k=>$v)
        {
            if(preg_match("/[a-z]+/", $k, $match))
            {
                preg_match($numPre, $k, $num);
                switch ($match[0])
                {
                    case "multiplechoice": $choice["MCID"][$num[0]] = $v; break;
                    case "rankchoice": $choice["RCID"][$num[0]] = $v; break;
                    case "singlechoice": $choice["SCID"][$num[0]] = $v;break;
                    case "trueorfalsechoice": $choice["TFCID"][$num[0]] = $v;break;
                }
            }
        }
        $cho = [];
        foreach($choice as $k=>$v)
        {
            if(!empty($v))
            {
                $ite = new choiceItems($this->ff[$k]);
                $chItems = $ite->easySql->select_or(array($k=>array_keys($v)), "*");
                foreach ($chItems as $key=>$value)
                {
                    $chItems[$key]["errorChoice"] = $v[$value[$k]];
                }
                $cho =  array_merge($cho, $chItems);
            }
        }
        returnAjaxData('1', "成功", $cho);
    }



    function examResult()
    {
        $neadArg = ["EID"=>[true, 1], "userid"=>[true, 0], "questionCount"=>[true, 1], "startTime"=>[true, 0], "EndTime"=>[true, 0], "signature"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $neadArg2 = ["answer"=>true, 0];
        $answer = checkArg($neadArg2, "POST");
        $info["startTime"] = date("Y-m-d H:i:s",$info["startTime"]);
        $info["EndTime"] = date("Y-m-d H:i:s",$info["EndTime"]);
        $info["userid"] = $this->userid;
        $exam = new items("zyexam");
        $examInfo = $exam->easySql->get_one(array("EID"=>$info["EID"]));
        if(empty($examInfo))
            returnAjaxData("-1","未检测到这场考试");
        $acceptExam = json_decode($examInfo["member"], true);
        $finishExam = json_decode($examInfo["finishMember"], true);
        $num = count($finishExam);
        foreach($acceptExam as $key=>$value)
        {
            if($value == $info["userid"]) //*********************************userid
            {
                $acceptExam[$key] = '';
                $finishExam[] = $value;
                break;
            }
        }
        if($num == count($finishExam))
            returnAjaxData("1","你不是这次考试的成员");
        list($data,$userInfo,$examTime )  = $this->getChoice(["EID"=>$info["EID"]], ",answer");
        $exam->easySql->changepArg(["member"=>json_encode($acceptExam), "finishMember"=>json_encode($finishExam)],array("EID"=>$info["EID"]));
        $info["rightID"] = [];
        $info["errorID"] = [];
        foreach ($data as $key=>$value)
        {
            $str = '';
            switch ($value["choiceType"])
            {
                case "singlechoice": $str="singlechoice".$value["SCID"];break;
                case "multiplechoice":$str="multiplechoice".$value["MCID"];break;
                case "rankchoice":$str="rankchoice".$value["RCID"];break;
                case "trueorfalsechoice":$str="trueorfalsechoice".$value["TFCID"];break;
            }
            if($value["choiceType"] == "multiplechoice")
            {
                $sort = explode(",", $answer["answer"][$str]);
                array_pop($sort);
                sort($sort);
                $answer["answer"][$str] = implode('', $sort);
            }
            if($value["choiceType"] == "rankchoice" && $answer["answer"][$str] != '')
            {
                $answer["answer"][$str] = implode('', $answer["answer"][$str]);
            }
            if($answer["answer"][$str] == $value["answer"])
                $info["rightID"][] = $str;
            else
                $info["errorID"][$str] = $answer["answer"][$str];
        }
        $info["rightCount"] = count($info["rightID"]);
        $info["errorCount"] = count($info["errorID"]);
        $info["examResults"] = round($info["rightCount"]/$info["questionCount"]*100, 2);
        $info["rightID"] = json_encode($info["rightID"]);
        $info["errorID"] = json_encode($info["errorID"]);
        $examResult = new items("zyexamresults");
        $examResult->easySql->add($info);
        returnAjaxData('1','成功', ["examResult"=>$info["examResults"]]);
    }

    function getExamResult()
    {
        $neadArg = ["userid"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $info["userid"] =  $this->userid;
        $examResult = new items("zyexamresults");
        $data = $examResult->getExamResult($info);
        returnAjaxData("1", "成功", $data);
    }

}