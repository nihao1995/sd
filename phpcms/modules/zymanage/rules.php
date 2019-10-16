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
class rules extends admin
{
    function init()
    {
        include $this->admin_tpl('rules\rules');
    }
    function addRulesManage()
    {
        if(!empty($_POST))
        {
            $neadArg = ['titlename'=>[true, 0],'abstract'=>[false, 0], "editorValue"=>[true, 0]];
            $info = checkArg($neadArg, "POST");
            //$info["fileAddr"] = json_encode($info["fileAddr"], JSON_UNESCAPED_UNICODE );
            $info["addtime"] = date("Y-m-d H:i:s",time());
            $item = new items("zyrules");
            $item->easySql->add($info);
            returnAjaxData('1','添加成功');
        }
        else
        {
            include $this->admin_tpl('rules\rulesFileAdd');
        }
    }
    function editRulesManage()
    {
        if(!empty($_POST))
        {
            $neadArg = ['titlename'=>[true, 0],'abstract'=>[true, 0, "摘要"], "editorValue"=>[true, 0], "RID"=>[true, 0]];
            $info = checkArg($neadArg, "POST");
            //$info["fileAddr"] = json_encode($info["fileAddr"], JSON_UNESCAPED_UNICODE );
            $where["RID"] = array_pop($info);
            $item = new items("zyrules");
            $item->easySql->changepArg($info, $where);
            returnAjaxData('1','添加成功');
        }
        else
        {
            $neadArg = ["RID"=>[true, 0]];
            $info = checkArg($neadArg);
            $item = new items("zyrules");
            $data = $item->easySql->get_one($info);
            include $this->admin_tpl('rules\rulesFileEdit');
        }
    }
    function getRulesData()
    {
        $neadArg = ["page"=>[true, 0], "titlename"=>[false, 0]];
        $info = checkArg($neadArg, "POST");
        $item = new items("zyrules");
        $page = array_shift($info);
        list($data, $pagenums, $pageStart, $pageCount) = $item->getRulesFileInfo($info, $page);
        returnAjaxData('1', '成功', ['data'=>$data,'pagenums'=>$pagenums, 'pageStart'=>$pageStart, 'pageCount'=>$pageCount]);
    }
    function delRulesData()
    {
        $neadArg = ["RID"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $exam = new items("zyrules");
        $exam->easySql->del($info);
        returnAjaxData('1', '成功');
    }
    function delIDI()
    {
        $neadArg = ["RID"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $exam = new items("zyrules");
        $exam->easySql->del_or($info);
        returnAjaxData('1', '成功');
    }








































    //****************************************************文件式规章
    function rulesfile()
    {
        include $this->admin_tpl('rulesfile\rulesfile');
    }
    function getData()
    {
        $neadArg = ["page"=>[true, 0], "titlename"=>[false, 0]];
        $info = checkArg($neadArg, "POST");
        $item = new items("zyrulesfile");
        $page = array_shift($info);
        list($data, $pagenums, $pageStart, $pageCount) = $item->getRulesFileInfo($info, $page);
        returnAjaxData('1', '成功', ['data'=>$data,'pagenums'=>$pagenums, 'pageStart'=>$pageStart, 'pageCount'=>$pageCount]);
    }
    function delData()
    {
        $neadArg = ["RFID"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $items = new items('zyrulesfile');
        $items->del($info);
        returnAjaxData('1', '删除成功');
    }

    function editFileManage()
    {
        if(!empty($_POST))
        {
            $neadArg = ['titlename'=>[true, 0], 'fileAddr'=>[true, 0], "RFID"=>[true, 0]];
            $info = checkArg($neadArg, "POST");
            $where["RFID"] = array_pop($info);
            $info["fileAddr"] = json_encode($info["fileAddr"], JSON_UNESCAPED_UNICODE );
            $item = new items("zyrulesfile");
            $item->easySql->changepArg($info, $where);
            returnAjaxData('1','修改成功');
        }
        else
        {
            $neadArg = ["RFID"=>[true, 0]];
            $info = checkArg($neadArg);
            $item = new items('zyrulesfile');
            $dataInfo = $item->easySql->get_one($info);
            $category = $item->easySql->get_one($info);
            include $this->admin_tpl('rulesfile\rulesfileEdit');
        }
    }
    function addFileManage()
    {
        if(!empty($_POST))
        {
            $neadArg = ['titlename'=>[true, 0],'fileAddr'=>[true, 0]];
            $info = checkArg($neadArg, "POST");
            $info["fileAddr"] = json_encode($info["fileAddr"], JSON_UNESCAPED_UNICODE );
            $info["addtime"] = date("Y-m-d H:i:s",time());
            $item = new items("zyrulesfile");
            $item->easySql->add($info);
            returnAjaxData('1','添加成功');
        }
        else
        {
            include $this->admin_tpl('rulesfile\rulesfileAdd');
        }
    }
    function delID()
    {
        $neadArg = ["RFID"=>[true, 0]];
        $info = checkArg($neadArg, "POST");
        $exam = new items("zyrulesfile");
        $exam->easySql->del_or($info);
        returnAjaxData('1', '成功');
    }

}