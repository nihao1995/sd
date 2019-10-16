<?php
defined('IN_PHPCMS') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
/* 获取模块标题 */
$moviemenu = $menu_db->get_one(array(
    'name' => 'moviemenu',
    'parentid' => 0
));

/* 判断模块标题 */
if ($moviemenu) {
    $moviemenuid = $moviemenu['id'];
} else {
    /* 创建模块标题 */
    $moviemenuid = $menu_db->insert(array(
        'name' => 'moviemenu',
        'parentid' => 0,
        'm' => 'movie',
        'c' => 'movie',
        'a' => '',
        'data' => '',
        'listorder' => 0,
        'display' => '1'
    ), true);
}

/* 创建管理标题 */
$moviemanageid = $menu_db->insert(array(
    'name' => 'moviemanage',
    'parentid' => $moviemenuid,
    'm' => 'movie',
    'c' => 'movie',
    'a' => '',
    'data' => '',
    'listorder' => 0,
    'display' => '1'
), true);

/* 创建列表标题 */
$menu_db->insert(array(
    'name' => 'movielist',
    'parentid' => $moviemanageid,
    'm' => 'movie',
    'c' => 'movie',
    'a' => 'init',
    'data' => '',
    'listorder' => 0,
    'display' => '1'
));

/* 翻译 */
$language = array(
    'moviemenu' => '视频模块',
    'moviemanage' => '视频管理',
    'movielist' => '视频列表'
);
?>