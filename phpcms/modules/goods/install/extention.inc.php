<?php
defined('IN_PHPCMS') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
/* 获取模块标题 */
$goodsmenu = $menu_db->get_one(array(
    'name' => 'goodsmenu',
    'parentid' => 0
));

/* 判断模块标题 */
if ($goodsmenu) {
    $goodsmenuid = $goodsmenu['id'];
} else {
    /* 创建模块标题 */
    $goodsmenuid = $menu_db->insert(array(
        'name' => 'goodsmenu',
        'parentid' => 0,
        'm' => 'goods',
        'c' => 'goods',
        'a' => '',
        'data' => '',
        'listorder' => 0,
        'display' => '1'
    ), true);
}

/* 创建管理标题 */
$goodsmanageid = $menu_db->insert(array(
    'name' => 'goodsmanage',
    'parentid' => $goodsmenuid,
    'm' => 'goods',
    'c' => 'goods',
    'a' => '',
    'data' => '',
    'listorder' => 0,
    'display' => '1'
), true);

/* 创建列表标题 */
$menu_db->insert(array(
    'name' => 'goodslist',
    'parentid' => $goodsmanageid,
    'm' => 'goods',
    'c' => 'goods',
    'a' => 'init',
    'data' => '',
    'listorder' => 0,
    'display' => '1'
));

/* 创建管理标题 */
$classifymanageid = $menu_db->insert(array(
    'name' => 'classifymanage',
    'parentid' => $goodsmenuid,
    'm' => 'goods',
    'c' => 'goods',
    'a' => '',
    'data' => '',
    'listorder' => 0,
    'display' => '1'
), true);

/* 创建列表标题 */
$menu_db->insert(array(
    'name' => 'classifylist',
    'parentid' => $classifymanageid,
    'm' => 'goods',
    'c' => 'goods',
    'a' => 'classify',
    'data' => '',
    'listorder' => 0,
    'display' => '1'
));

/* 翻译 */
$language = array(
    'goodsmenu' => '商品模块',
    'goodsmanage' => '商品管理',
    'goodslist' => '商品列表',
    'classifymanage' => '分类管理',
    'classifylist' => '分类列表'
);
?>