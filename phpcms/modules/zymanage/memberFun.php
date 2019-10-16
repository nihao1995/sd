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
class memberFun extends admin
{
    public $roleid;
    function __construct()
    {
        $this->roleid = $_SESSION["roleid"];
        $workshop = new items("admin");
        $workshopInfo = $workshop->getAdminInfo($_SESSION["userid"], $_SESSION["roleid"]);
    }

    function init()
    {
        include $this->admin_tpl('departmentTree\departmentTree');
    }
    function addDepartMent()
    {
        $neadArg = ['DID'=>[true, 1]];
        $info = checkArgBcak($neadArg, "POST");
        $shopType = new items("zydepartment");
        $zNodes = $shopType->easySql->get_one($info);
        returnAjaxData('1', '成功', $zNodes);
    }
    public function getDepartMent()
    {
        $shopType = new items("zydepartment");
        $zNodes = $shopType->easySql->select("1","`DID` as id, `workshop` as name, isshow, pId");
        returnAjaxData('1', '成功', $zNodes);
    }
    public function addTypeAjax()
    {
        $neadArg = ["workshop"=>[true, 0], "pId"=>[true, 1]];
        $info = checkArgBcak($neadArg, "POST");
        $shopType = new items("zydepartment");
        $id = $shopType->easySql->add($info);
        returnAjaxData('1', '成功', $id);
    }
    public function changepArgAjax()
    {
        $neadArg = ['pId'=>[false, 1], "workshop"=>[false, 0], 'isshow'=>[false, 1],  'DID'=>[true, 1]];
        $info = checkArgBcak($neadArg, "POST");
        $shopType = new items("zydepartment");
        $where["DID"] = array_pop($info);
        $shopType->easySql->changepArg($info, $where);
        returnAjaxData('1', '成功');
    }
    public function delAjax()
    {
        $neadArg = ['DID'=>[true, 0]];
        $info = checkArgBcak($neadArg, 'POST');
        $shopType = new items("zydepartment");
        $shopType->easySql->del_or($info);
        returnAjaxData('1', '成功');
    }



    public function getSpecAjax()
    {
        $neadArg = ['DID'=>[true, 1]];
        $info = checkArgBcak($neadArg, "POST");
        $shopType = new items("zydepartment");
        $departmentInfo = $shopType->easySql->get_one($info, "workshop");
        $member = new items("member");
        $memberInfo = $member->easySql->select($departmentInfo, "userid, nickname, job_number");
        $shopType = new items("zymembergl");
        list($zNodes, $count) = $shopType->getMemberInfo($info);
        returnAjaxData('1', '成功', ["memberInfo"=>$memberInfo, "isManagement"=>$zNodes]);
    }

    public function addSpecAjax()
    {
        $neadArg = ['userid'=>[true, 1], "DID"=>[true, 0]];
        $info = checkArgBcak($neadArg, "POST");
        $info["addtime"] = date("Y-m-d H:i:s",time());
        $shopType = new items("zymembergl");
        $shopType->easySql->add($info);
        returnAjaxData('1', "成功");
    }
    public function delSpecAjax()
    {
        $neadArg = ['MGLID'=>[true, 1]];
        $info = checkArgBcak($neadArg, "POST");
        $shopType = new items("zymembergl");
        $shopType->easySql->del($info);
        returnAjaxData('1', '成功');
    }

}