<?php
// +------------------------------------------------------------
// | 卓远网络1.0
// +------------------------------------------------------------
// | 卓远网络：YYY QQ:185017580 http://www.300c.cn/
// +------------------------------------------------------------
// | 欢迎加入卓远网络-Team，和卓远一起，精通PHPCMS
// +------------------------------------------------------------
// | 版本号：20171010
// +------------------------------------------------------------


defined('IN_PHPCMS') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');


/**
 * 添加父级菜单:后台添加一个卓远商城菜单
 */



//先判断有没有卓远网络的大菜单
$zywldb = $menu_db->get_one(array('name'=>'zymanage','parentid'=>'0'));
if($zywldb){
	$parentid =$zywldb['id'];
}else{
	$parentid = $menu_db->insert(
	array(
		'name'=>'zymanage',
		'parentid'=>'0',
		'm'=>'zymanage',
		'c'=>'manage',
		'a'=>'init',
		'data'=>'',
		'listorder'=>9,
		'display'=>'1'
		),
	true
    );
}


/**
 * 添加菜单:excel导入导出
 */
$pid = $menu_db->insert(
	array(
		'name'=>'videoManage', //菜单名称
		'parentid'=>$parentid, //添加到后台的主菜单里
		'm'=>'zymanage', //模块
		'c'=>'videoManage', //文件
		'a'=>'init',//方法
		'data'=>'', //附加参数
		'listorder'=>1, //菜单排序
		'display'=>'1'), //显示菜单 1是显示 0是隐藏
		true //插入菜单之后，是否返回id
	);
$pid2 = $menu_db->insert(
    array(
        'name'=>'fileManage', //菜单名称
        'parentid'=>$parentid, //添加到后台的主菜单里
        'm'=>'zymanage', //模块
        'c'=>'fileManage', //文件
        'a'=>'init',//方法
        'data'=>'', //附加参数
        'listorder'=>0, //菜单排序
        'display'=>'1'), //显示菜单 1是显示 0是隐藏
    true //插入菜单之后，是否返回id
);
$pid3 = $menu_db->insert(
    array(
        'name'=>'slideshowMange', //菜单名称
        'parentid'=>$parentid, //添加到后台的主菜单里
        'm'=>'zymanage', //模块
        'c'=>'slideshowMange', //文件
        'a'=>'init',//方法
        'data'=>'', //附加参数
        'listorder'=>4, //菜单排序
        'display'=>'1'), //显示菜单 1是显示 0是隐藏
    true //插入菜单之后，是否返回id
);
$pid4 = $menu_db->insert(
    array(
        'name'=>'studyPlan', //菜单名称
        'parentid'=>$parentid, //添加到后台的主菜单里
        'm'=>'zymanage', //模块
        'c'=>'studyPlan', //文件
        'a'=>'init',//方法
        'data'=>'', //附加参数
        'listorder'=>3, //菜单排序
        'display'=>'1'), //显示菜单 1是显示 0是隐藏
    true //插入菜单之后，是否返回id
);
$pid5 = $menu_db->insert(
    array(
        'name'=>'pkMatching', //菜单名称
        'parentid'=>$parentid, //添加到后台的主菜单里
        'm'=>'zymanage', //模块
        'c'=>'pkMatching', //文件
        'a'=>'init',//方法
        'data'=>'', //附加参数
        'listorder'=>5, //菜单排序
        'display'=>'1'), //显示菜单 1是显示 0是隐藏
    true //插入菜单之后，是否返回id
);
$pid6 = $menu_db->insert(
    array(
        'name'=>'rules', //菜单名称
        'parentid'=>$parentid, //添加到后台的主菜单里
        'm'=>'zymanage', //模块
        'c'=>'rules', //文件
        'a'=>'init',//方法
        'data'=>'', //附加参数
        'listorder'=>6, //菜单排序
        'display'=>'1'), //显示菜单 1是显示 0是隐藏
    true //插入菜单之后，是否返回id
);

$menu_db->insert(
	array(
		'name'=>'video', //菜单名称
		'parentid'=>$pid, //添加到积分商城。
		'm'=>'zymanage', //模块
		'c'=>'videoManage',//文件
		'a'=>'init', //方法
		'data'=>'', //附加参数
		'listorder'=>0, //菜单排序
		'display'=>'1' //显示菜单 1是显示 0是隐藏
		),true
	);
/**
 * 添加子菜单：excel导入
 */
$menu_db->insert(
    array(
        'name'=>'file', //菜单名称
        'parentid'=>$pid2, //添加到积分商城。
        'm'=>'zymanage', //模块
        'c'=>'fileManage',//文件
        'a'=>'init', //方法
        'data'=>'', //附加参数
        'listorder'=>0, //菜单排序
        'display'=>'1' //显示菜单 1是显示 0是隐藏
    ),true
);
$menu_db->insert(
    array(
        'name'=>'manageType', //菜单名称
        'parentid'=>$pid4, //添加到积分商城。
        'm'=>'zymanage', //模块
        'c'=>'studyPlan',//文件
        'a'=>'manageType', //方法
        'data'=>'', //附加参数
        'listorder'=>0, //菜单排序
        'display'=>'1' //显示菜单 1是显示 0是隐藏
    ),true
);
$menu_db->insert(
    array(
        'name'=>'slideshowMange', //菜单名称
        'parentid'=>$pid3, //添加到积分商城。
        'm'=>'zymanage', //模块
        'c'=>'slideshowMange',//文件
        'a'=>'init', //方法
        'data'=>'', //附加参数
        'listorder'=>0, //菜单排序
        'display'=>'1' //显示菜单 1是显示 0是隐藏
    ),true
);
$menu_db->insert(
    array(
        'name'=>'studyPlan', //菜单名称
        'parentid'=>$pid4, //添加到积分商城。
        'm'=>'zymanage', //模块
        'c'=>'studyPlan',//文件
        'a'=>'init', //方法
        'data'=>'', //附加参数
        'listorder'=>0, //菜单排序
        'display'=>'1' //显示菜单 1是显示 0是隐藏
    ),true
);
$menu_db->insert(
    array(
        'name'=>'pkMatchingRecord', //菜单名称
        'parentid'=>$pid5, //添加到积分商城。
        'm'=>'zymanage', //模块
        'c'=>'pkMatching',//文件
        'a'=>'pkMatchingRecord', //方法
        'data'=>'', //附加参数
        'listorder'=>0, //菜单排序
        'display'=>'1' //显示菜单 1是显示 0是隐藏
    ),true
);
$menu_db->insert(
    array(
        'name'=>'pkMatchingConfig', //菜单名称
        'parentid'=>$pid5, //添加到积分商城。
        'm'=>'zymanage', //模块
        'c'=>'pkMatching',//文件
        'a'=>'pkMatchingConfig', //方法
        'data'=>'', //附加参数
        'listorder'=>0, //菜单排序
        'display'=>'1' //显示菜单 1是显示 0是隐藏
    ),true
);
$menu_db->insert(
    array(
        'name'=>'rules', //菜单名称
        'parentid'=>$pid6, //添加到积分商城。
        'm'=>'zymanage', //模块
        'c'=>'rules',//文件
        'a'=>'init', //方法
        'data'=>'', //附加参数
        'listorder'=>0, //菜单排序
        'display'=>'1' //显示菜单 1是显示 0是隐藏
    ),true
);
$menu_db->insert(
    array(
        'name'=>'rulesfile', //菜单名称
        'parentid'=>$pid6, //添加到积分商城。
        'm'=>'zymanage', //模块
        'c'=>'rules',//文件
        'a'=>'rulesfile', //方法
        'data'=>'', //附加参数
        'listorder'=>0, //菜单排序
        'display'=>'1' //显示菜单 1是显示 0是隐藏
    ),true
);
/**
 * 添加子菜单：excel导入_测试数据
 */



/**
 * 添加子菜单：excel导出
 */

/**
 * 添加子菜单：excel导出_测试数据
 */
/**$menu_db->insert(
	array(
		'name'=>'excel_dc_ceshi', //菜单名称
		'parentid'=>$piddr, //添加到积分商城。
		'm'=>'zyexcel', //模块
		'c'=>'excel',//文件
		'a'=>'excel_dc_ceshi', //方法
		'data'=>'', //附加参数
		'listorder'=>0, //菜单排序
		'display'=>'0' //显示菜单 1是显示 0是隐藏
		)
	);*/






/**
 * 菜单名称翻译
 */
$language = array(
	'zymanage'=>'管理模块',
	'videoManage'=>'视频管理',
	"fileManage"=>'文件管理',
	'video'=>'视频',
    'file'=>'文件',
    'manageType'=>'所属类型',
    'slideshowMange'=>'轮播图',
	'studyPlan'=>'学习计划',
	'pkMatching'=>'在线匹配对战',
	'pkMatchingRecord'=>'对战记录',
	'pkMatchingConfig'=>'对战配置',
	'rules'=>'规章制度',
	'rulesfile'=>'规章文件',
);





/*卓远网络
	商城管理
		列表*/



?>