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
            case "notice": return \pc_base::load_model("announce_model");
            case "notice_type": return \pc_base::load_model("notice_type_model");
            case "zyfxconfig": return \pc_base::load_model("zyfxconfig_model");
            case "zyfxmoney": return \pc_base::load_model("zyfxmoney_model");
            case "zyshop": return \pc_base::load_model("zyshop_model");
            case "order": return \pc_base::load_model("order_model");
            case "zyaddress": return \pc_base::load_model("zyaddress_model");
            default:\Res::Error("没有这个model");
        }
    }
}