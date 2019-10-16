<?php
/**
 * Created by PhpStorm.
 * User: 徐强
 * Date: 2019/6/5
 * Time: 14:09
 */

namespace zymanage\classes;
use zymanage\classes\modelFactory as excelModelFactory;

class easySql //处理简单的增删改查
{
    function __construct($modelName)
    {
        $this->easySql = excelModelFactory::Create()->getModel($modelName);
    }

    function select($where="1", $parameter="*", $limit='', $order='')
    {
        $info = $this->easySql->select($where, $parameter, $limit, $order);
        return $info;
    }
    function select_or($where="1", $parameter="*", $limit='', $order='')
    {
        $info = $this->easySql->select_or($where, $parameter, $limit, $order);
        return $info;
    }
    function get_one($where, $parameter="*")
    {
        $info = $this->easySql->get_one($where, $parameter);
        return $info;
    }

    function add($info)
    {
        $id = $this->easySql->insert($info, true);
        return $id;
    }
    function changepArg($info, $where)
    {
        $this->easySql->update($info, $where);
    }
    function del_or($info)
    {
        $this->easySql->delete_or($info);
    }
    function del($info)
    {
        $this->easySql->delete($info);
    }
}