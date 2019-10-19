<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);	//加载应用类方法
pc_base::load_sys_class('form', 0, 0);
pc_base::load_app_func('global');
pc_base::load_sys_class('Res', '', 0);
use zyshop\classes\items as items;
use zyshop\classes\testItems as testItems;
/**
 * Created by PhpStorm.
 * User: 徐强
 * Date: 2019/6/27
 * Time: 14:22
 */
class shopManage extends admin
{
    function init()
    {
        include $this->admin_tpl('zyshop\shopManage');
    }
    function examGrade() //考试页面获取数据
    {
        $examType = new items("zyexam");
        $examAll = json_encode($examType->easySql->select("1", "EID,titlename"), JSON_UNESCAPED_UNICODE);
        include $this->admin_tpl('examGrade\examGrade');
    }
    function getData() //主页面获取数据
    {
        $neadArg = ["page"=>[true, 1], "titlename"=>[false, 0], "SID"=>[false, 1]];
        $info = checkArg($neadArg, $_POST);
        $item = new items("zyshop");
        $page = array_shift($info);
        list($data, $pagenums, $pageStart, $pageCount) = $item->getShopInfo($info, $page);
        returnAjaxData('200', '成功', ['data'=>$data,'pagenums'=>$pagenums, 'pageStart'=>$pageStart, 'pageCount'=>$pageCount]);
    }
    function delData() //删除单条数据
    {
        $neadArg = ["SID"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $items = new items('zyshop');
        $items->del($info);
        returnAjaxData('200', '删除成功');
    }
    function addShop() //添加商品
    {
        if(!empty($_POST))
        {
            $neadArg = ['titlename'=>[true, 0,"请输入商品标题"], "endtime"=>[true, 0, "请选择结束时间"],"num"=>[true, 1, "请输入商品数量"],"thumb"=>[true, 0],'thumbs'=>[false, 0], "money"=>[true, 0],  "description"=>[true, 0]];
            $info = checkArg($neadArg, $_POST);
            if(isset($info["thumbs"]))
                $info["thumbs"] = json_encode($info["thumbs"]);
            $info["addtime"] = date("Y-m-d H:i:s", time());
            $info["residueNum"] = $info["num"];
            $item = new items("zyshop");
            $item->easySql->add($info);
            returnAjaxData('200','添加成功');
        }
        else
        {
            $upload_allowext = 'jpg|jpeg|gif|png|bmp';
            $isselectimage = '1';
            $images_width = '';
            $images_height = '';
            $watermark = '0';
            $authkey = upload_key("1,$upload_allowext,$isselectimage,$images_width,$images_height,$watermark");


            $upload_number = '50';
            $upload_allowext = 'gif|jpg|jpeg|png|bmp';
            $isselectimage = '0';
            $authkeys = upload_key("$upload_number,$upload_allowext,$isselectimage");

            include $this->admin_tpl('zyshop\shopAdd');
        }
    }
    function editShop() //考试编辑
    {
        if(!empty($_POST))
        {
            $neadArg =  ['EID'=>[true, 0],'titlename'=>[true, 0], "examTime"=>[true, 0],"SCID"=>[false, 0],"MCID"=>[false, 0],'TFCID'=>[false, 0], 'RCID'=>[false, 0],"dateStart"=>[true, 0], "dateEnd"=>[true, 0],"member"=>[true, 0]];
            $info = checkArg($neadArg, "POST");
            $where["EID"] = array_shift($info);
            $info["timestampStart"] = strtotime($info["dateStart"]);
            $info["timestampEnd"] = strtotime($info["dateEnd"]);
            if(isset($info["SCID"]))  $info["SCID"] = json_encode($info["SCID"], JSON_UNESCAPED_UNICODE ); else $info["SCID"] = '';
            if(isset($info["RCID"]))  $info["RCID"] = json_encode($info["RCID"], JSON_UNESCAPED_UNICODE );else $info["RCID"] = '';
            if(isset($info["MCID"]))  $info["MCID"] = json_encode($info["MCID"], JSON_UNESCAPED_UNICODE );else $info["MCID"] = '';
            if(isset($info["TFCID"]))  $info["TFCID"] = json_encode($info["TFCID"], JSON_UNESCAPED_UNICODE );else $info["TFCID"] = '';
            if(isset($info["member"]))  $info["member"] = json_encode($info["member"], JSON_UNESCAPED_UNICODE );
            $item = new items("zyexam");
            $item->easySql->changepArg($info, $where);
            returnAjaxData('1','修改成功');
        }
        else
        {
            $neadArg = ["SID"=>[true, 0]];
            $info = checkArg($neadArg, $_GET);
            $item = new items('zyshop');
            $dataInfo = $item->easySql->get_one($info);
            $upload_allowext = 'jpg|jpeg|gif|png|bmp';
            $isselectimage = '1';
            $images_width = '';
            $images_height = '';
            $watermark = '0';
            $authkey = upload_key("1,$upload_allowext,$isselectimage,$images_width,$images_height,$watermark");


            $upload_number = '50';
            $upload_allowext = 'gif|jpg|jpeg|png|bmp';
            $isselectimage = '0';
            $authkeys = upload_key("$upload_number,$upload_allowext,$isselectimage");

            include $this->admin_tpl('zyshop\shopEdit');
        }
    }








    function viewExam() //查看考题
    {
        $neadArg = ["SCID"=>[false, 3], "MCID"=>[false, 3], "TFCID"=>[false, 3], "RCID"=>[false, 3]];
        $info = checkArg($neadArg);
        $str = '';
        if($info == null)
            returnAjaxData("-1", "请传入参数");
        foreach ($info as $key=>$value)
        {
            switch ($key)
            {
                case "SCID":$item = new testItems("zysinglechoice");$str="examManage\\SMChoiceView";break;
                case "MCID":$item = new testItems("zymultiplechoice");$str="examManage\\SMChoiceView";break;
                case "RCID":$item = new testItems("zyrankchoice");$str="examManage\\SMChoiceView";break;
                case "TFCID":$item = new testItems("zytrueorfalsechoice");$str="examManage\\TFChoiceView";break;
            }
        }
        $dataInfo = $item->easySql->get_one($info);
        include $this->admin_tpl($str);
    }
    function addExam() //添加考试
    {
        if(!empty($_POST))
        {
            $neadArg = ['titlename'=>[true, 0], "SCID"=>[false, 0],"MCID"=>[false, 0],"RCID"=>[false, 0],'TFCID'=>[false, 0], "examTime"=>[true, 0],  "dateStart"=>[true, 0], "dateEnd"=>[true, 0],"member"=>[true, 0]];
            $info = checkArg($neadArg, "POST");
            $info["timestampStart"] = strtotime($info["dateStart"]);
            $info["timestampEnd"] = strtotime($info["dateEnd"]);
            $info["addtime"] = date("Y-m-d H:i:s",time());


            if(isset($info["SCID"]))  $info["SCID"] = json_encode($info["SCID"], JSON_UNESCAPED_UNICODE );
            if(isset($info["MCID"]))  $info["MCID"] = json_encode($info["MCID"], JSON_UNESCAPED_UNICODE );
            if(isset($info["RCID"]))  $info["RCID"] = json_encode($info["RCID"], JSON_UNESCAPED_UNICODE );
            if(isset($info["TFCID"]))  $info["TFCID"] = json_encode($info["TFCID"], JSON_UNESCAPED_UNICODE );
            if(isset($info["member"]))  $info["member"] = json_encode($info["member"], JSON_UNESCAPED_UNICODE );
            if(isset($info["finishMember"]))  $info["finishMember"] = json_encode([], JSON_UNESCAPED_UNICODE );
            $item = new items("zyexam");
            $item->easySql->add($info);
            returnAjaxData('1','添加成功');
        }
        else
        {
            include $this->admin_tpl('examManage\examManageAdd');
        }
    }
    function getChoice() //获取题目
    {
        $items = new testItems("zysinglechoice");
        list($singlechoice, $multiplechoice, $trueorfalsechoice, $rankchoice) = $items->getCategoryItems('1');
        $member = new items("member");
        $memberData = $member->easySql->select('1', "nickname,userid", '');
        returnAjaxData('1', "成功", ["singlechoice"=>$singlechoice, "multiplechoice"=>$multiplechoice, "trueorfalsechoice"=>$trueorfalsechoice, "member"=>$memberData, "rankchoice"=>$rankchoice]);
    }



    function getGrade() //获取成绩
    {
        $neadArg = ["EID"=>[true, 1]];
        $info = checkArg($neadArg, "POST");
        $examGrade = new items("zyexamresults");
        list($examResults, $count) = $examGrade->getExamGrade($info);
        returnAjaxData('1', "成功", ["examResults"=>$examResults,"count"=>$count]);
    }
    function delID() //批量删除
    {
        $neadArg = ["EID"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $exam = new items("zyexam");
        $exam->easySql->del_or($info);
        returnAjaxData('1', '成功');
    }
}