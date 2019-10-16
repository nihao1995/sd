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
$zywldb = $menu_db->get_one(array('name'=>'zyexam','parentid'=>'0'));
if($zywldb){
	$parentid =$zywldb['id'];
}else{
	$parentid = $menu_db->insert(
	array(
		'name'=>'zyexam',
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
		'name'=>'zyexam', //菜单名称
		'parentid'=>$parentid, //添加到后台的主菜单里
		'm'=>'zyexam', //模块
		'c'=>'examManage', //文件
		'a'=>'init',//方法
		'data'=>'', //附加参数
		'listorder'=>0, //菜单排序
		'display'=>'1'), //显示菜单 1是显示 0是隐藏
		true //插入菜单之后，是否返回id
	);
	/*
$pid2 = $menu_db->insert(
    array(
        'name'=>'fileManage', //菜单名称
        'parentid'=>$parentid, //添加到后台的主菜单里
        'm'=>'zyexam', //模块
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
        'listorder'=>0, //菜单排序
        'display'=>'1'), //显示菜单 1是显示 0是隐藏
    true //插入菜单之后，是否返回id
);
*/

$menu_db->insert(
	array(
		'name'=>'examManage', //菜单名称
		'parentid'=>$pid, //添加到积分商城。
		'm'=>'zyexam', //模块
		'c'=>'examManage',//文件
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
        'name'=>'examGrade', //菜单名称
        'parentid'=>$pid, //添加到积分商城。
        'm'=>'zyexam', //模块
        'c'=>'examManage',//文件
        'a'=>'examGrade', //方法
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
	'zyexam'=>'考试模块',
	'examManage'=>'考试管理',
	"examGrade"=>'考试成绩',
	//'video'=>'视频',
    //'file'=>'文件',
    //'manageType'=>'所属类型',
    //'slideshowMange'=>'轮播图',
	//'studyPlan'=>'学习计划'
);





/*卓远网络
	商城管理
		列表*/



?>