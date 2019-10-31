<?php
/**
 * Created by PhpStorm.
 * User: 徐强
 * Date: 2019/4/25
 * Time: 14:12
 */
//工厂模式取model文件
namespace  zyshop\classes;

interface model_List
{
    static function getModel($modelName);
}
class modelList implements model_List
{
    public function __construct()
    {
    }
    static function getModel($modelName = '')
    {
        switch ($modelName)
        {
            case "zyshop": return \pc_base::load_model("zyshop_model");
            case "zyslideshow": return \pc_base::load_model("zyslideshow_model");
            case "member": return \pc_base::load_model("member_model");
            case "zyaddress": return \pc_base::load_model("zyaddress_model");
            case "fxconfig": return \pc_base::load_model("zyfxconfig_model");
            default:\Res::Error("没有这个model");
        }
        // TODO: Implement getModel() method.
    }
}
class modelFactory
{
    public static function Create()
    {
        return new modelList();
    }
}