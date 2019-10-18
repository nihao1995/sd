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
            case "zycs_model": return \pc_base::load_model("zycs_model");
            case "zycs2_model": return \pc_base::load_model("zycs2_model");
            case "zyexcelerror": return \pc_base::load_model("zyexcelerror_model");
            case "zyexcelconfig": return \pc_base::load_model("zyexcelconfig_model");
            case "zyexam": return \pc_base::load_model("zyexam_model");
            case "zyexamresults": return \pc_base::load_model("zyexamresults_model");
            case "member": return \pc_base::load_model("member_model");
            case "zysinglechoice": return \pc_base::load_model("zysinglechoice_model");
            case "zymultiplechoice": return \pc_base::load_model("zymultiplechoice_model");
            case "zyrankchoice": return \pc_base::load_model("zyrankchoice_model");
            case "zytrueorfalsechoice": return \pc_base::load_model("zytrueorfalsechoice_model");
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