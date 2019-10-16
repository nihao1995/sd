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

class items
{
    public $DB;
    public $easySql;
    public $pagesize = 8;
    public $type;
    function __construct($type)
    {
        $this->type = $type;
        $this->DB = mf::Create()->getModel($type);
        $this->easySql = new easySql($type);
    }
    function getVideoInfo($where,$page = 1)
    {
        $where = returnWhereSQL($where);
        list($info, $count) = $this->DB->moreTableSelect(array('zy_'.$this->type=>array("*"), 'zy_zymanagetype'=>array('*')), array("VFTID"), $where, ((string)($page-1)*$this->pagesize).",".$this->pagesize, "B1.addtime DESC","1");
        //$info["options"] = json_decode($info['options'], true);
        list($page, $pagenums, $pageStart, $pageCount) = getPage($page, $this->pagesize, $count);
        $category = (new easySql("zymanagetype"))->select(array("typeshow"=>'1'), "distinct `typename`, VFTID");
        return array($info, $pagenums, $pageStart, $pageCount, $category);
    }
    function getFileInfo($where,$page = 1)
    {
        $where = returnWhereSQL($where);
        list($info, $count) = $this->DB->moreTableSelect(array('zy_'.$this->type=>array("*")), array(), $where, ((string)($page-1)*$this->pagesize).",".$this->pagesize, "B1.addtime DESC","1");
        //$info["options"] = json_decode($info['options'], true);
        list($page, $pagenums, $pageStart, $pageCount) = getPage($page, $this->pagesize, $count);
        return array($info, $pagenums, $pageStart, $pageCount);
    }

    function getExamGrade($where)
    {
        $where = returnWhereSQL($where);
        list($info, $count) = $this->DB->moreTableSelect(array('zy_'.$this->type=>array("*"), "zy_member"=>array("nickname"), "zy_zyexam"=>array("titlename")), array("userid", "EID"), $where, '', "B1.examResults DESC","1");
        return array($info,$count);
    }

    function getExamResult($info)
    {
        $where = returnWhereSQL($info);
        list($data, $count) =  $this->DB->moreTableSelect(array('zy_'.$this->type=>array("*"), "zy_zyexam"=>array("titlename")), array("EID"), $where, "", "B1.EndTime DESC","1");
        return $data;
    }


    function del($where)
    {
        $this->easySql->del($where);
    }
}