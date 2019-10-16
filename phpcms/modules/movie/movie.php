<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_app_func('upload');

class movie extends admin
{

    function __construct()
    {
        parent::__construct();
        /* 视频表 */
        $this->movie_db = pc_base::load_model("movie_model");
        /* 商品_视频表 */
        $this->goods_movie_db = pc_base::load_model("goods_movie_model");
    }

    /* 视频列表 */
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
        $movies = $this->movie_db->listinfo($where .= 1, "ID DESC", $_GET['page'], 20);
        $pages = $this->movie_db->pages;
        include $this->admin_tpl("index");
    }

    /* 视频修改 */
    function edit()
    {
        if (empty($_POST['dosubmit'])) {
            $id = $_GET['id'];
            if (! empty($id)) {
                $movie = $this->movie_db->get_one(array(
                    'id' => $id
                ));
                include $this->admin_tpl("edit");
            } else {
                showmessage("视频编号为空");
            }
        } else {
            $id = $_GET['id'];
            $movie = $_POST['movie'];
            if (! empty($id) && ! empty($movie)) {
                if (empty($movie['title'])) {
                    showmessage("视频标题为空");
                }
                if (empty($movie['thumb'])) {
                    showmessage("视频图片为空");
                }
                if (empty($movie['filename'])) {
                    showmessage("视频文件为空");
                }
                $movie['updatetime'] = time();
                $this->movie_db->update($movie, array(
                    'id' => $id
                ));
                showmessage("", "", "", "edit");
            } else {
                if (empty($id)) {
                    showmessage("视频编号为空");
                }
                if (empty($movie)) {
                    showmessage("视频参数为空");
                }
            }
        }
    }

    /* 视频查看 */
    function view()
    {
        if (empty($_POST['dosubmit'])) {
            $id = $_GET['id'];
            if (! empty($id)) {
                $movie = $this->movie_db->get_one(array(
                    'id' => $id
                ));
                include $this->admin_tpl("view");
            } else {
                showmessage("视频编号为空");
            }
        } else {
            showmessage("", "", "", "view");
        }
    }

    /* 视频删除 */
    function delete()
    {
        $id = $_GET['id'];
        if (! empty($id)) {
            $this->movie_db->delete(array(
                'id' => $id
            ));
            $this->goods_movie_db->delete(array(
                'mid' => $id
            ));
            showmessage("操作成功", "?m=movie&c=movie&a=init", 500);
        } else {
            showmessage("非法访问");
        }
    }

    /* 文件上传 */
    function upload()
    {
        $path = dirname(dirname(dirname(__DIR__))) . "/upload/movie";
        $filename = siteurl(get_siteid()) . "/upload/movie/" . pathinfo(upload($_FILES['file'], $path), PATHINFO_BASENAME);
        $result = array(
            'filename' => $filename
        );
        exit(json_encode($result));
    }
}
?>