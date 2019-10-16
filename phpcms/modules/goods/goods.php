<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_app_func('upload');

class goods extends admin
{

    function __construct()
    {
        parent::__construct();
        /* 商品表 */
        $this->goods_db = pc_base::load_model("goods_model");
        /* 商品_视频表 */
        $this->goods_movie_db = pc_base::load_model("goods_movie_model");
        /* 商品_分组表 */
        $this->goods_group_db = pc_base::load_model("goods_group_model");
        /* 商品_分类表 */
        $this->goods_classify_db = pc_base::load_model("goods_classify_model");
        /* 视频表 */
        $this->movie_db = pc_base::load_model("movie_model");
        /* 分组表 */
        $this->group_db = pc_base::load_model("group_model");
        /* 分组_分类表 */
        $this->group_classify_db = pc_base::load_model("group_classify_model");
        /* 分类表 */
        $this->classify_db = pc_base::load_model("classify_model");
        /* 分类_属性表 */
        $this->classify_value_db = pc_base::load_model("classify_value_model");
        /* 会员_收藏表 */
        $this->member_goods_db = pc_base::load_model('member_goods_model');
    }

    /* 商品列表 */
    function init()
    {
        $where = "";
        $id = $_POST['id'];
        $uid = $_POST['uid'];
        $title = $_POST['title'];
        $uploadtime = $_POST['uploadtime'];
        $updatetime = $_POST['updatetime'];
        if (! empty($id)) {
            $where .= "id = {$id} AND ";
        }
        if (! empty($uid)) {
            $where .= "uid = {$uid} AND ";
        }
        if (! empty($title)) {
            $where .= "title LIKE '%{$title}%' AND ";
        }
        if (! empty($uploadtime)) {
            $time = explode(" - ", $uploadtime);
            $time[0] = strtotime($time[0]);
            $time[1] = strtotime($time[1]);
            $where .= "uploadtime BETWEEN {$time[0]} AND {$time[1]} AND ";
        }
        if (! empty($updatetime)) {
            $time = explode(" - ", $updatetime);
            $time[0] = strtotime($time[0]);
            $time[1] = strtotime($time[1]);
            $where .= "updatetime BETWEEN {$time[0]} AND {$time[1]} AND ";
        }
        $goodss = $this->goods_db->listinfo($where .= 1, "ID DESC", $_GET['page'], 20);
        $pages = $this->movie_db->pages;
        include $this->admin_tpl("index");
    }

    /* 商品修改 */
    function edit()
    {
        if (empty($_POST['dosubmit'])) {
            $id = $_GET['id'];
            if (! empty($id)) {
                $goods = $this->goods_db->get_one(array(
                    'id' => $id
                ));
                $goods['thumblist'] = json_decode($goods['thumblist']);
                /* 获取相关视频 */
                $movies = array();
                foreach ($this->goods_movie_db->listinfo("gid = {$id}") as $row) {
                    $movies[] = $this->movie_db->get_one(array(
                        'id' => $row['mid']
                    ));
                }
                /* 获取相关分类 */
                $classifys = $this->classify_db->listinfo();
                for ($i = 0; $i < count($classifys); $i ++) {
                    $classifys[$i]['value'] = $this->classify_value_db->listinfo("cid = {$classifys[$i]['id']}");
                    if ($classifys[$i]['type'] == 2) {
                        foreach ($this->goods_classify_db->listinfo("gid = {$id} AND cid = {$classifys[$i]['id']}") as $value) {
                            $classifys[$i]['selected'][] = $this->classify_value_db->get_one(array(
                                'id' => $value['vid']
                            ));
                        }
                    } else {
                        $classifys[$i]['selected'] = $this->classify_value_db->get_one(array(
                            'id' => $this->goods_classify_db->get_one(array(
                                'gid' => $id,
                                'cid' => $classifys[$i]['id']
                            ))['vid']
                        ));
                    }
                }
                $groups = $this->group_db->listinfo(array(
                    'uid' => $goods['uid']
                ));
                for ($i = 0; $i < count($groups); $i ++) {
                    $groups[$i]['classify'] = $this->group_classify_db->listinfo(array(
                        'cid' => $groups[$i]['id']
                    ));
                }
                $group = $this->goods_group_db->get_one(array(
                    'gid' => $id
                ));
                $str = $group['cid'] . ' - ' . $group['vid'];
                include $this->admin_tpl("edit");
            } else {
                showmessage("商品编号为空");
            }
        } else {
            $id = $_GET['id'];
            $goods = $_POST['goods'];
            $group = $_POST['group'];
            $movies = $_POST['movie'];
            $classifys = $_POST['classify'];
            if (! empty($id) && ! empty($goods) && ! empty($movies)) {
                if (empty($goods['title'])) {
                    showmessage("商品标题为空");
                }
                if (empty($goods['content'])) {
                    showmessage("商品简介为空");
                }
                if (empty($goods['thumb'])) {
                    showmessage("商品缩略图为空");
                }
                if (empty($goods['thumblist'])) {
                    showmessage("商品详情图为空");
                }
                if (empty($goods['real_price'])) {
                    showmessage("商品零售价为空");
                }
                if (empty($goods['fake_price'])) {
                    showmessage("商品市场价为空");
                }
                $goods['thumblist'] = json_encode($goods['thumblist']);
                $goods['updatetime'] = time();
                $this->goods_db->update($goods, array(
                    'id' => $id
                ));
                /* 修改相关视频 */
                $this->goods_movie_db->delete(array(
                    'gid' => $id
                ));
                foreach ($movies as $mid) {
                    $this->goods_movie_db->insert(array(
                        'gid' => $id,
                        'mid' => $mid
                    ));
                }
                /* 修改相关分类 */
                $this->goods_classify_db->delete(array(
                    'gid' => $id
                ));
                foreach ($classifys as $cid => $vid) {
                    if (is_array($vid)) {
                        foreach ($vid as $val) {
                            $this->goods_classify_db->insert(array(
                                'gid' => $id,
                                'cid' => $cid,
                                'vid' => $val
                            ));
                        }
                    } else {
                        $this->goods_classify_db->insert(array(
                            'gid' => $id,
                            'cid' => $cid,
                            'vid' => $vid
                        ));
                    }
                }
                /* 修改相关分组 */
                $this->goods_group_db->delete(array(
                    'gid' => $id
                ));
                $group = explode(" - ", $group);
                $this->goods_group_db->insert(array(
                    'gid' => $id,
                    'cid' => $group[0],
                    'vid' => $group[1]
                ));
                showmessage("", "", "", "edit");
            } else {
                if (empty($id)) {
                    showmessage("商品编号为空");
                }
                if (empty($goods)) {
                    showmessage("商品参数为空");
                }
                if (empty($movies)) {
                    showmessage("课程视频为空");
                }
            }
        }
    }

    /* 商品查看 */
    function view()
    {
        if (empty($_POST['dosubmit'])) {
            $id = $_GET['id'];
            if (! empty($id)) {
                $goods = $this->goods_db->get_one(array(
                    'id' => $id
                ));
                $goods['thumblist'] = json_decode($goods['thumblist']);
                /* 获取相关视频 */
                $movies = array();
                foreach ($this->goods_movie_db->listinfo("gid = {$id}") as $row) {
                    $movies[] = $this->movie_db->get_one(array(
                        'id' => $row['mid']
                    ));
                }
                /* 获取相关分类 */
                $classifys = $this->classify_db->listinfo();
                for ($i = 0; $i < count($classifys); $i ++) {
                    $classifys[$i]['value'] = $this->classify_value_db->listinfo("cid = {$classifys[$i]['id']}");
                    if ($classifys[$i]['type'] == 2) {
                        foreach ($this->goods_classify_db->listinfo("gid = {$id} AND cid = {$classifys[$i]['id']}") as $value) {
                            $classifys[$i]['selected'][] = $this->classify_value_db->get_one(array(
                                'id' => $value['vid']
                            ));
                        }
                        foreach ($classifys[$i]['selected'] as $value) {
                            $classifys[$i]['selected_value'][] = $value['name'];
                        }
                    } else {
                        $classifys[$i]['selected'] = $this->classify_value_db->get_one(array(
                            'id' => $this->goods_classify_db->get_one(array(
                                'gid' => $id,
                                'cid' => $classifys[$i]['id']
                            ))['vid']
                        ));
                    }
                }
                $group = $this->goods_group_db->get_one(array(
                    'gid' => $id
                ));
                if ($group['vid'] != 0) {
                    $group = $this->group_classify_db->get_one(array(
                        'id' => $group['vid']
                    ))['name'];
                } else {
                    $group = $this->group_db->get_one(array(
                        'id' => $group['cid']
                    ))['name'];
                }
                include $this->admin_tpl("view");
            } else {
                showmessage("商品编号为空");
            }
        } else {
            showmessage("", "", "", "view");
        }
    }

    /* 商品删除 */
    function delete()
    {
        $id = $_GET['id'];
        if (! empty($id)) {
            $this->goods_db->delete(array(
                'id' => $id
            ));
            /* 删除关联视频 */
            $this->goods_movie_db->delete(array(
                'gid' => $id
            ));
            /* 删除关联分组 */
            $this->goods_group_db->delete(array(
                'gid' => $id
            ));
            /* 删除关联分类 */
            $this->goods_classify_db->delete(array(
                'gid' => $id
            ));
            $this->member_goods_db->delete(array(
                'gid' => $id
            ));
            showmessage("操作成功", "?m=goods&c=goods&a=init", "500");
        } else {
            showmessage("商品编号为空");
        }
    }

    /* 状态修改 */
    function status()
    {
        $id = $_GET['id'];
        $status = $_GET['status'];
        if (! empty($id) && ! empty($status)) {
            $this->goods_db->update(array(
                'sale' => $status
            ), array(
                'id' => $id
            ));
            showmessage("操作成功", "?m=goods&c=goods&a=init", "500");
        } else {
            if (empty($id)) {
                showmessage("商品编号为空");
            }
            if (empty($status)) {
                showmessage("状态码为空");
            }
        }
    }

    /* 视频列表 */
    function video()
    {
        $uid = $_GET['uid'];
        if (! empty($uid)) {
            $movies = $this->movie_db->listinfo("uid = {$uid}", "TITLE");
            include $this->admin_tpl("video");
        } else {
            showmessage("用户编号为空");
        }
    }

    /* 分类列表 */
    function classify()
    {
        $classifys = $this->classify_db->listinfo("", "ID DESC", $_GET['page'], 20);
        $pages = $this->classify_db->pages;
        /* 顶部按钮 */
        $big_menu = array(
            "javascript:window.top.art.dialog({id:'add',iframe:'?m=goods&c=goods&a=add_classify', title:'分类添加', width:'500', height:'500'}, function(){var d = window.top.art.dialog({id:'add'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'add'}).close()});void(0);",
            "分类添加"
        );
        include $this->admin_tpl("classify");
    }

    /* 分类添加 */
    function add_classify()
    {
        if (empty($_POST['dosubmit'])) {
            include $this->admin_tpl("add_classify");
        } else {
            $classify = $_POST['classify'];
            if (empty($classify['name'])) {
                showmessage("分类名称为空");
            }
            $this->classify_db->insert($classify);
            showmessage("", "", "", "add");
        }
    }

    /* 分类修改 */
    function edit_classify()
    {
        if (empty($_POST['dosubmit'])) {
            $id = $_GET['id'];
            if (! empty($id)) {
                $classify = $this->classify_db->get_one(array(
                    'id' => $id
                ));
                include $this->admin_tpl("edit_classify");
            } else {
                showmessage("分类编号为空");
            }
        } else {
            $id = $_GET['id'];
            $classify = $_POST['classify'];
            if (! empty($id) && ! empty($classify)) {
                $this->classify_db->update($classify, array(
                    'id' => $id
                ));
                showmessage("", "", "", "edit");
            } else {
                if (empty($id)) {
                    showmessage("分类编号为空");
                }
                if (empty($classify)) {
                    showmessage("分类参数为空");
                }
            }
        }
    }

    /* 分类删除 */
    function delete_classify()
    {
        $id = $_GET['id'];
        if (! empty($id)) {
            $this->classify_db->delete(array(
                'id' => $id
            ));
            $this->classify_value_db->delete(array(
                'cid' => $id
            ));
            $this->goods_classify_db->delete(array(
                'cid' => $id
            ));
            showmessage("操作成功", "?m=goods&c=goods&a=classify", "500");
        } else {
            showmessage("分类编号为空");
        }
    }

    /* 属性列表 */
    function classify_value()
    {
        $cid = $_GET['cid'];
        if (! empty($cid)) {
            $classify_values = $this->classify_value_db->listinfo("cid = {$cid}", "ID DESC", $_GET['page'], 20);
            $pages = $this->classify_value_db->pages;
            include $this->admin_tpl("classify_value");
        } else {
            showmessage("分类编号为空");
        }
    }

    /* 属性添加 */
    function add_classify_value()
    {
        if (empty($_POST['dosubmit'])) {
            include $this->admin_tpl("add_classify_value");
        } else {
            $classify_value = $_POST['classify_value'];
            if (empty($classify_value['name'])) {
                showmessage("属性名称为空");
            }
            $this->classify_value_db->insert($classify_value);
            showmessage("", "", "", "append");
        }
    }

    /* 属性修改 */
    function edit_classify_value()
    {
        if (empty($_POST['dosubmit'])) {
            $id = $_GET['id'];
            if (! empty($id)) {
                $classify_value = $this->classify_value_db->get_one(array(
                    'id' => $id
                ));
                include $this->admin_tpl("edit_classify_value");
            } else {
                showmessage("属性编号为空");
            }
        } else {
            $id = $_GET['id'];
            $classify_value = $_POST['classify_value'];
            if (! empty($id) && ! empty($classify_value)) {
                $this->classify_value_db->update($classify_value, array(
                    'id' => $id
                ));
                showmessage("", "", "", "edit");
            } else {
                if (empty($id)) {
                    showmessage("属性编号为空");
                }
                if (empty($classify_value)) {
                    showmessage("属性参数为空");
                }
            }
        }
    }

    /* 属性删除 */
    function delete_classify_value()
    {
        $id = $_GET['id'];
        $cid = $_GET['cid'];
        if (! empty($id) && ! empty($cid)) {
            $this->classify_value_db->delete(array(
                'id' => $id
            ));
            $this->goods_classify_db->delete(array(
                'vid' => $id
            ));
            showmessage("操作成功", "?m=goods&c=goods&a=classify_value&cid={$cid}", "500");
        } else {
            if (empty($id)) {
                showmessage("属性编号为空");
            }
            if (empty($cid)) {
                showmessage("分类编号为空");
            }
        }
    }

    /* 文件上传 */
    function upload()
    {
        $path = dirname(dirname(dirname(__DIR__))) . "/upload/goods";
        $filename = siteurl(get_siteid()) . "/upload/goods/" . pathinfo(upload($_FILES['file'], $path), PATHINFO_BASENAME);
        $result = array(
            'filename' => $filename
        );
        exit(json_encode($result));
    }
}
?>