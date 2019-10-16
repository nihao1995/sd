<?php
pc_base::load_app_func('upload');
pc_base::load_app_func("utilities");

class api
{

    function __construct()
    {
        /* 视频表 */
        $this->movie_db = pc_base::load_model("movie_model");
        /* 商品_视频表 */
        $this->goods_movie_db = pc_base::load_model("goods_movie_model");
    }

    /**
     * 视频添加
     *
     * @param
     *            movie[uid] 用户编号
     * @param
     *            movie[title] 视频标题
     * @param
     *            movie[thumb] 视频图片
     * @param
     *            movie[filename] 视频文件
     */
    function add()
    {
        $movie = $_POST['movie'];
        $movie['uid'] = $movie['uid'] ? $movie['uid'] : param::get_cookie("_userid");
        if (empty($movie['uid']) || empty($movie['title']) || empty($movie['thumb']) || empty($movie['filename'])) {
            _return_code(- 1, "error", "请填写完整视频参数");
        }
        $movie['uploadtime'] = time();
        $movie['updatetime'] = time();
        $this->movie_db->insert($movie);
        _return_code(200, "success", "操作成功");
    }

    /**
     * 视频修改
     *
     * @param
     *            id 视频编号
     * @param
     *            movie[title] 视频标题
     * @param
     *            movie[thumb] 视频图片
     * @param
     *            movie[filename] 视频文件
     */
    function edit()
    {
        $id = $_POST['id'];
        $movie = $_POST['movie'];
        if (empty($id)) {
            _return_code(- 1, "error", "请填写视频编号");
        }
        if (empty($movie['title']) || empty($movie['thumb']) || empty($movie['filename'])) {
            _return_code(- 2, "error", "请填写完整视频参数");
        }
        $movie['updatetime'] = time();
        $this->movie_db->update($movie, array(
            'id' => $id
        ));
        _return_code(200, "success", "操作成功");
    }

    /**
     * 视频删除
     *
     * @param
     *            id 视频编号
     */
    function delete()
    {
        $id = $_POST['id'];
        if (empty($id)) {
            _return_code(- 1, "error", "请填写视频编号");
        }
        $this->movie_db->delete(array(
            'id' => $id
        ));
        /* 删除关联数据 */
        $this->goods_movie_db->delete(array(
            'mid' => $id
        ));
        _return_code(200, "success", "操作成功");
    }

    /**
     * 视频获取（单个）
     *
     * @param
     *            id 视频编号
     */
    function get()
    {
        $id = $_POST['id'];
        if (empty($id)) {
            _return_code(- 1, "error", "请填写视频编号");
        }
        $movie = $this->movie_db->get_one(array(
            'id' => $id
        ));
        _return_data(200, "success", "操作成功", array(
            'movie' => $movie
        ));
    }

    /**
     * 视频获取（全部）
     *
     * @param
     *            uid 用户编号
     * @param
     *            sort 排序规则 [NAME:视频标题|TIME:上传时间]
     * @param
     *            page 当前页码
     * @param
     *            pagesize 显示数目
     */
    function getAll()
    {
        $order = "";
        $sort = $_POST['sort'];
        $page = $_POST['page'] ? $_POST['page'] : 1;
        $pagesize = $_POST['pagesize'] ? $_POST['pagesize'] : 20;
        $uid = $_POST['uid'] ? $_POST['uid'] : param::get_cookie("_userid");
        if (empty($uid)) {
            _return_code(- 1, "error", "请填写用户编号");
        }
        $where = array(
            'uid' => $uid
        );
        if (! empty($sort)) {
            if ($sort == 'NAME') {
                $order .= 'TITLE';
            } elseif ($sort == 'TIME') {
                $order .= 'UPLOADTIME DESC';
            }
        }
        $movies = $this->movie_db->listinfo($where, $order, $page, $pagesize);
        $pages['page'] = $page;
        $pages['pagesize'] = $pagesize;
        $pages['totalnum'] = $this->movie_db->count($where);
        $pages['totalpage'] = ceil($pages['totalnum'] / $pagesize);
        _return_data(200, "success", "操作成功", array(
            'movies' => $movies,
            'pages' => $pages
        ));
    }

    /**
     * 文件上传
     */
    function upload()
    {
        $path = dirname(dirname(dirname(__DIR__))) . "/upload/movie";
        $filename = siteurl(get_siteid()) . "/upload/movie/" . pathinfo(upload($_FILES['file'], $path), PATHINFO_BASENAME);
        _return_data(200, "success", "操作成功", array(
            'filename' => $filename
        ));
    }
}