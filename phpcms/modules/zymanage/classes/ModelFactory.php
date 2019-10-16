<?php
/**
 * Created by PhpStorm.
 * User: 徐强
 * Date: 2019/4/25
 * Time: 14:12
 */
//工厂模式取model文件
namespace  zymanage\classes;

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
            case "zycs_model": return \pc_base::load_model("zycs_model");
            case "zycs2_model": return \pc_base::load_model("zycs2_model");
            case "zyexcelerror": return \pc_base::load_model("zyexcelerror_model");
            case "zyexcelconfig": return \pc_base::load_model("zyexcelconfig_model");
            case "zysinglechoice": return \pc_base::load_model("zysinglechoice_model");
            case "zymultiplechoice": return \pc_base::load_model("zymultiplechoice_model");
            case "zyvideo": return \pc_base::load_model("zyvideo_model");
            case "zystudyplan": return \pc_base::load_model("zystudyplan_model");
            case "zymanagetype": return \pc_base::load_model("zymanagetype_model");
            case "zyfile": return \pc_base::load_model("zyfile_model");
            case "zyslideshow": return \pc_base::load_model("zyslideshow_model");
            case "zypkconfig": return \pc_base::load_model("zypkconfig_model");
            case "zypkrecord": return \pc_base::load_model("zypkrecord_model");
            case "zyintegralinfo": return \pc_base::load_model("zyintegralinfo_model");
            case "member": return \pc_base::load_model("member_model");
            case "zyrulesfile": return \pc_base::load_model("zyrulesfile_model");
            case "zyrules": return \pc_base::load_model("zyrules_model");
            case "zydepartment": return \pc_base::load_model("zydepartment_model");
            case "zymembergl": return \pc_base::load_model("zymembergl_model");
            case "admin": return \pc_base::load_model("admin_model");
            case "admin_role": return \pc_base::load_model("admin_role_model");
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