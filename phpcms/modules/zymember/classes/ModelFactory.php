<?php
/**
 * Created by PhpStorm.
 * User: 徐强
 * Date: 2019/4/25
 * Time: 14:12
 */
//工厂模式取model文件
namespace  zymember\classes;

class modelFactory
{
    static function dbFactory($db = '')
    {
        switch ($db)
        {
            case "member": return \pc_base::load_model("member_model");
            case "bankcard": return \pc_base::load_model("zybankcard_model");
            default:\Res::Error("没有这个model");
        }
    }
}