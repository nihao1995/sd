<?php
/**
 * Created by PhpStorm.
 * User: 徐强
 * Date: 2019/6/29
 * Time: 10:19
 */

namespace zymanage\classes;
use zymanage\classes\easySql as easySql;
use zymanage\classes\modelFactory as mf;


class items
{
    public $DB;
    public $easySql;
    public $pagesize = 8;
    public $type;
    public $adminDB;

    function __construct($type)
    {
        $this->type = $type;
        $this->DB = mf::Create()->getModel($type);
        $this->easySql = new easySql($type);
    }

    function getVideoInfo($where, $page = 1)
    {
        $where = returnWhereSQL($where);
        list($info, $count) = $this->DB->moreTableSelect(array('zy_' . $this->type => array("*"), 'zy_zymanagetype' => array('*')), array("VFTID"), $where, ((string)($page - 1) * $this->pagesize) . "," . $this->pagesize, "B1.addtime DESC", "1");
        //$info["options"] = json_decode($info['options'], true);
        list($page, $pagenums, $pageStart, $pageCount) = getPage($page, $this->pagesize, $count);
        $category = (new easySql("zymanagetype"))->select(array("typeshow" => '1'), "distinct `typename`, VFTID");
        return array($info, $pagenums, $pageStart, $pageCount, $category);
    }

    function getFileInfo($where, $page = 1)
    {
        $where = returnWhereSQL($where);
        list($info, $count) = $this->DB->moreTableSelect(array('zy_' . $this->type => array("*"), 'zy_zymanagetype' => array('*')), array("VFTID"), $where, ((string)($page - 1) * $this->pagesize) . "," . $this->pagesize, "B1.addtime DESC", "1");
        //$info["options"] = json_decode($info['options'], true);
        list($page, $pagenums, $pageStart, $pageCount) = getPage($page, $this->pagesize, $count);
        $category = (new easySql("zymanagetype"))->select(array("typeshow" => '1'), "distinct `typename`, VFTID");
        return array($info, $pagenums, $pageStart, $pageCount, $category);
    }

    function getRulesFileInfo($where, $page = 1, $str = "*")
    {
        $where = returnWhereSQL($where);
        list($info, $count) = $this->DB->moreTableSelect(array('zy_' . $this->type => array($str)), array(), $where, ((string)($page - 1) * $this->pagesize) . "," . $this->pagesize, "B1.addtime DESC", "1");
        //$info["options"] = json_decode($info['options'], true);
        list($page, $pagenums, $pageStart, $pageCount) = getPage($page, $this->pagesize, $count);
        return array($info, $pagenums, $pageStart, $pageCount);
    }

    function getPKData($page, $info = [])
    {
        $where = '`grade0`  is not null  AND `grade1`  is not null ';
        if (!empty($where)) {
            $where .= " AND (`nickname0`  like '%" . $info["nickname"] . "%' OR `nickname1`  like '%" . $info["nickname"] . "%')";
        }
        list($info, $count) = $this->DB->moreTableSelect(array('zy_' . $this->type => array("*")), array(), $where, ((string)($page - 1) * $this->pagesize) . "," . $this->pagesize, "B1.addtime DESC", "1");
        list($page, $pagenums, $pageStart, $pageCount) = getPage($page, $this->pagesize, $count);
        return array($info, $pagenums, $pageStart, $pageCount);
    }

    function del($where)
    {
        $this->easySql->del($where);
    }



    function getMemberInfo($where)
    {
        list($info, $count) = $this->DB->moreTableSelect(array("zy_".$this->type=>array("*"), "zy_member"=>["userid", "nickname", "job_number"]), array("userid"), $where, "", "", "1");
        return array($info, $count);
    }

    function getAdminInfo($userid, $roleid)
    {
        list($userInfo, $count) = $this->DB->moreTableSelect(["zy_admin"=>["*"], "zy_admin_role"=>['*']], ["roleid"], ["userid"=>$userid], 1, "", "0");
        $this->adminDB = new easySql("zydepartment");
        $departmentInfo = $this->adminDB->get_one(["workshop"=>$userInfo["rolename"]]);
        $workshop[] = $departmentInfo["workshop"];
        $this->getDepartment($departmentInfo["DID"], $workshop);
        return $workshop;
    }

    function getDepartment($DID, &$workshop)
    {
        $info = $this->adminDB->easySql->select(["pID"=>$DID], "DID, workshop");
        if(!empty($info))
        {
            foreach ($info as $key=>$value)
            {
                $workshop[] = $value["workshop"];
                $this->getDepartment($value["DID"], $workshop);
            }
        }
    }

}