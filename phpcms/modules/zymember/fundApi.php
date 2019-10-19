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

use zymember\classes\FundControl as fc;

class fundApi
{
    public $fund;
    function __construct()
    {
        $this->fund = new fc();
    }

    public function add_bank_card(){
        $data=checkArg(["userid"=>[true,1,"请输入用户ID"],"bank_cardid"=>[true,0,"请输入银行卡号"],"bank_name"=>[true,0,"请输入开户银行"],"bank_branch"=>[true,0,"请输入所属支行"],"owner_name"=>[true,0,"请输入持卡人姓名"]],$_POST);
        $id=$this->fund->add_bank_card($data);
        if($id){
            returnAjaxData(200,"操作成功",$id);
        }else{
            returnAjaxData(-200,"操作失败");
        }
    }

    /**
     * 完善资料
     * @status [状态] -1手机号码不能为空/-2用户名格式错误/-3帐号不存在/-4短信验证码错误/-5密码格式错误/-11 密码输入不一致/-100操作错误，进度错误
     *
     * @param [type] $mobile
     *            [*手机号码]
     * @param [type] $verify_code
     *            [*手机验证码]
     * @param [type] $password
     *            [2*用户密码]
     * @param [type] $repassword
     *            [2*重复密码]
     * @param [type] $progress
     *            [*进度：1输入手机号码；2发送短信验证码；3设置密码]
     * @param [type] $type
     *            [*类型：1web端、2APP端]
     * @param [type] $forward
     *            [接下来该跳转的页面链接]
     * @return [json] [json数组]
     */
    public function edit_card()
    {
        $type = $_POST['type'] ? $_POST['type'] : 1; // 类型：1web端、2APP端
        $forward = $_POST['forward'] ? urldecode($_POST['forward']) : APP_PATH . 'index.php?m=member&c=index'; // 接下来该跳转的页面链接

        $mobile = $_POST['mobile']; // 手机号
        $verify_code = $_POST['verify_code']; // 短信验证码
        $realname = $_POST['realname'];
        $bankname = $_POST['bankname'];
        $bankcard = $_POST['bankcard'];
        $idcard = $_POST['idcard'];
        $userid = $_POST['userid'];
        $idcard_positive = $_POST['idcard_positive'];
        $idcard_negative = $_POST['idcard_negative'];
        if (! $realname || ! $bankname || ! $bankcard || ! $idcard || ! $userid|| ! $idcard_positive|| ! $idcard_negative) {
            $result = [
                'status' => 'error',
                'code' => - 1,
                'message' => '参数不能为空'

            ];
            exit(json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }
        // 用手机号码查出用户账号
        $memberinfo = $this->member_db->get_one(array(
            'userid' => $userid
        ));

        // ================== 操作失败-验证 START
        // 帐号密码类型不能为空
        if (! $mobile) {
            $result = [
                'status' => 'error',
                'code' => - 1,
                'message' => '手机号码不能为空'

            ];
            exit(json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }
        // 用户名格式验证（手机号码格式验证）
        if (! $this->_verify_ismobile($mobile)) {
            $result = [
                'status' => 'error',
                'code' => - 2,
                'message' => '手机号码格式错误' // 只允许 13，14，15，16，17，18，19的号码,11位

            ];
            exit(json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }
        // 帐号不存在
        if (! $memberinfo) {
            $result = [
                'status' => 'error',
                'code' => - 3,
                'message' => '帐号不存在' // 帐号不存在

            ];
            exit(json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }
        // ================== 操作失败-验证 END

        // ================== 操作失败-验证 START
        // 短信验证码错误
        // 调用通讯模块-短信接口-查询此账号的短信验证码是否匹配上了
        // $sms_verify = true;
        // ================== 获取其他接口-接口 START
        $config = $this->zyconfig_db->get_one(array(
            'key' => 'zymessagesys4'
        ), "url");
        $curl = [
            'mobile' => $mobile,
            'verify_code' => $verify_code,
            'clear' => 1
        ];
        $sms_verify = _crul_post($config['url'], $curl);
        $sms_verify = json_decode($sms_verify, true);
        // ================== 获取其他接口-接口 END

        if ($sms_verify['status'] == 'error') { // false,进入
            $result = [
                'status' => 'error',
                'code' => - 4,
                'message' => $sms_verify['message'] // 短信验证码错误

            ];
            exit(json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }
        // 扣除手续费
        $curl = [
            'userid' => $userid,
            'type' => 1
        ];
        $sms_verify = _crul_post(APP_PATH . 'index.php?m=zyadm&c=api&a=service_charge', $curl);
        $sms_verify = json_decode($sms_verify, true);
        // ================== 获取其他接口-接口 END
        if ($sms_verify['status'] == 'error') { // false,进入
            $result = [
                'status' => 'error',
                'code' => - 5,
                'message' => $sms_verify['message'] // 扣除手续费错误
            ];
            exit(json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }
        // ================== 操作失败-验证 END

        // ================== 操作成功-修改数据 START
        // 调用通讯模块-短信接口-清空此账号的短信验证码
        // 操作成功之后删除遗留的短信验证码
        // ================== 获取其他接口-接口 START
        $config = $this->zyconfig_db->get_one(array(
            'key' => 'zymessagesys5'
        ), "url");
        $curl = [
            'mobile' => $memberinfo['mobile']
        ];
        _crul_post($config['url'], $curl);
        // ================== 获取其他接口-接口 END

        // 更改数据库密码
        $data = [
            'realname' => $_POST['realname'],
            'bankname' => $_POST['bankname'],
            'bankcard' => $_POST['bankcard'],
            'idcard' => $_POST['idcard'],
            'idcard_positive' => $_POST['idcard_positive'],
            'idcard_negative' => $_POST['idcard_negative']
        ];

        $this->member_db->update($data, array(
            'userid' => $memberinfo['userid']
        ));
        if($this->is_all_set($memberinfo['userid'])){
            $this->member_db->update(array('identifiy_status'=>1),array(
                'userid' => $memberinfo['userid']
            ));
        }
        $result = [
            'status' => 'success',
            'code' => 200,
            'message' => '等待审核',
            'data' => [
                'userid' => $memberinfo['userid'],
                'groupid' => $memberinfo['groupid'],
                'forward' => $forward // 给web端用的，接下来跳转到哪里
            ]
        ];
        exit(json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        // ================== 操作成功-修改数据 END
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