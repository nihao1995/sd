<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('form', 0, 0);
pc_base::load_app_func('global');
pc_base::load_sys_class('Res', '', 0);
use zyshop\classes\items as items;
use zyshop\classes\testItems as testItems;

class shopApi {


    function getSlideshow(){
        $items = new items("zyslideshow");
        $data = $items->easySql->select(array("isshow"=>'1'), '*', '10', "addtime DESC");
        returnAjaxData("200", "成功", $data);
    }

    function getAddress(){
        $neadArg = ["userid"=>[true, 6]];
        $info = checkArg($neadArg, $_POST);
        $item = new items("zyaddress");
        $data = $item->easySql->select($info);
        returnAjaxData("200", "成功", $data);
    }
    function addAddress(){
        $neadArg = ["userid"=>[true, 6], "receivername"=>[true, 0, "请填写收件人姓名"], "phone"=>[true, "number", "请传入联系方式"], "address"=>[true, "0", "请传入地址详情"], "isDefault"=>[false, 1]];
        $info = checkArg($neadArg, $_POST);
        $items = new items("zyaddress");
        if(isset($info["isDefault"]) && $info["isDefault"] == "1")
        {
            $this->updateDefault($items, $info);
        }
        $items->easySql->add($info);
        returnAjaxData("200", "添加成功");
    }
    function editAddress(){
        $neadArg =[ "receivername"=>[false, 0, "请填写收件人姓名"], "phone"=>[false, "number", "请传入联系方式"], "address"=>[false, "0", "请传入地址详情"], "isDefault"=>[false, 1]];
        $info = checkArg($neadArg, $_POST);
        $whereArg = ["userid"=>[true, 6], "ADID"=>[true, 1]];
        $where = checkArg($whereArg, $_POST);
        $items = new items("zyaddress");
        if(isset($info["isDefault"]) && $info["isDefault"] == "1")
        {
            $sss = $info;
            $sss["userid"] = $where["userid"];
            $this->updateDefault($items, $sss);
        }
        $items->easySql->changepArg($info, $where);
        returnAjaxData("200", "修改成功");
    }
    function delAddress(){
        $whereArg = ["userid"=>[true, 6], "ADID"=>[true, 1]];
        $where = checkArg($whereArg, $_POST);
        $items = new items("zyaddress");
        $items ->easySql->del($where);
        returnAjaxData("200","删除成功");
    }



    function updateDefault($items, $info){
        $data = $items->easySql->get_one(["isDefault"=>"1", "userid"=>$info["userid"]]);
        if($data)
        {
            $items->easySql->changepArg(["isDefault"=>"0"], ["ADID"=>$data["ADID"]]);
        }
    }
    function upFile()
    {
        if (!empty ( $_FILES ['file'] ['name'] ))
            $tmp_file = $_FILES ['file'] ['tmp_name'];
        else
            returnAjaxData('-1','上传文件为空');
        $file_types = explode ( ".", $_FILES ['file'] ['name'] );
        $file_type = $file_types [count ( $file_types ) - 1];
        $basepath = str_replace( '\\' , '/' , realpath(dirname(__FILE__).'/../../../'));
        /*设置上传路径*/
        $time = date("Ymd", time());
        $savePath = $basepath.'/uploadfile/'.$time;
        if(!file_exists($savePath)){
            mkdir($savePath);
        }
        $file_name = $_FILES ['file'] ['name'];
        $str = date ( 'Ymdhis' ) + rand(1, 2000);
        $path = $savePath.'/'.$str.'.'.$file_type ;
        if(! copy ( $tmp_file, $path))
            returnAjaxData('-1', '上传失败');
        $uploadPath = APP_PATH.'uploadfile/'.$time.'/'.$str.'.'.$file_type;
        $returnData = ['name'=>$file_name, 'url'=>$uploadPath];
        returnAjaxData('1', 'success', $returnData);
    }
}