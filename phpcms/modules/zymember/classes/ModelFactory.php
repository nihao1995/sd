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
            case "get": return \pc_base::load_model("get_model");
            case "member": return \pc_base::load_model("member_model");
            case "bankcard": return \pc_base::load_model("zybankcard_model");
            case "fund_record": return \pc_base::load_model("fund_record_model");
            case "account_record": return \pc_base::load_model("account_record_model");
            default:\Res::Error("没有这个model");
        }
    }
}