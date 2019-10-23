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


}