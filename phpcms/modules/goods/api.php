<?php
pc_base::load_app_func('upload');
pc_base::load_app_func("utilities");

class api
{

    function __construct()
    {
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
    }

    /**
     * 商品添加
     *
     * @param
     *            goods[uid] 用户编号
     * @param
     *            goods[mode] 商品模式 [1:普通商品|2:拼团商品|3:砍价商品]
     * @param
     *            goods[free] 商品类型 [1:免费商品|-1:付费商品]
     * @param
     *            goods[sale] 商品状态 [1:上架商品|-1:下架商品]
     * @param
     *            goods[title] 商品标题
     * @param
     *            goods[content] 商品简介
     * @param
     *            goods[thumb] 商品缩略图
     * @param
     *            goods[thumblist][] 商品详情图
     * @param
     *            goods[real_price] 商品零售价
     * @param
     *            goods[fake_price] 商品市场价
     * @param
     *            movie[] 关联视频
     * @param
     *            classify[分类编号] 关联分类
     *            classify[分类编号][] 关联分类
     * @param
     *            group 关联分组 [选中分组:分组编号 - 0|选中分组_分类:分组编号 - 分类编号]
     * @param
     *            goods[type] 优惠类型 [1:拼团价|2:拼团折扣] [拼团商品]
     * @param
     *            goods[group_price] 商品拼团价 [拼团商品]
     * @param
     *            goods[discount] 拼团折扣 [拼团商品]
     * @param
     *            goods[number] 拼团人数 [拼团商品]
     */
    function add()
    {
        $goods = $_POST['goods'];
        $movie = $_POST['movie'];
        $group = $_POST['group'];
        $classify = $_POST['classify'];
        $goods['thumblist'] = json_encode($goods['thumblist']);
        $goods['uid'] = $goods['uid'] ? $goods['uid'] : param::get_cookie("_userid");
        if (empty($goods['uid']) || empty($goods['title']) || empty($goods['content']) || empty($goods['thumb']) || empty($goods['thumblist']) || empty($goods['real_price']) || empty($goods['fake_price'])) {
            _return_code(- 1, "error", "请填写完整商品参数");
        }
        if ($goods['mode'] == 2) {
            if (empty($goods['group_price']) && empty($goods['discount']) || empty($goods['number'])) {
                _return_code(- 2, "error", "请填写完整拼团商品参数");
            }
        }
        if (empty($movie)) {
            _return_code(- 3, "error", "请填写完整关联视频参数");
        }
        $goods['uploadtime'] = time();
        $goods['updatetime'] = time();
        $id = $this->goods_db->insert($goods, true);
        /* 添加关联视频 */
        foreach ($movie as $mid) {
            $this->goods_movie_db->insert(array(
                'gid' => $id,
                'mid' => $mid
            ));
        }
        /* 添加关联分组 */
        $group = explode(" - ", $group);
        $this->goods_group_db->insert(array(
            'gid' => $id,
            'cid' => $group[0],
            'vid' => $group[1]
        ));
        /* 添加关联分类 */
        foreach ($classify as $cid => $vid) {
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
        _return_code(200, "success", "操作成功");
    }

    /**
     * 商品修改
     *
     * @param
     *            id 商品编号
     * @param
     *            goods[mode] 商品模式 [1:普通商品|2:拼团商品|3:砍价商品]
     * @param
     *            goods[free] 商品类型 [1:免费商品|-1:付费商品]
     * @param
     *            goods[sale] 商品状态 [1:上架商品|-1:下架商品]
     * @param
     *            goods[title] 商品标题
     * @param
     *            goods[content] 商品简介
     * @param
     *            goods[thumb] 商品缩略图
     * @param
     *            goods[thumblist][] 商品详情图
     * @param
     *            goods[real_price] 商品零售价
     * @param
     *            goods[fake_price] 商品市场价
     * @param
     *            movie[] 关联视频
     * @param
     *            classify[分类编号] 关联分类
     *            classify[分类编号][] 关联分类
     * @param
     *            group 关联分组 [选中分组:分组编号 - 0|选中分组_分类:分组编号 - 分类编号]
     * @param
     *            goods[type] 优惠类型 [1:拼团价|2:拼团折扣] [拼团商品]
     * @param
     *            goods[group_price] 商品拼团价 [拼团商品]
     * @param
     *            goods[discount] 拼团折扣 [拼团商品]
     * @param
     *            goods[number] 拼团人数 [拼团商品]
     */
    function edit()
    {
        $id = $_POST['id'];
        $goods = $_POST['goods'];
        $movie = $_POST['movie'];
        $group = $_POST['group'];
        $classify = $_POST['classify'];
        $goods['thumblist'] = json_encode($goods['thumblist']);
        if (empty($id)) {
            _return_code(- 1, "error", "请填写商品编号");
        }
        if (empty($goods['title']) || empty($goods['content']) || empty($goods['thumb']) || empty($goods['thumblist']) || empty($goods['real_price']) || empty($goods['fake_price'])) {
            _return_code(- 2, "error", "请填写完整商品参数");
        }
        if ($goods['mode'] == 2) {
            if (empty($goods['group_price']) && empty($goods['discount']) || empty($goods['number'])) {
                _return_code(- 3, "error", "请填写完整拼团商品参数");
            }
        }
        if (empty($movie)) {
            _return_code(- 4, "error", "请填写完整关联视频参数");
        }
        $goods['updatetime'] = time();
        $this->goods_db->update($goods, array(
            'id' => $id
        ));
        /* 修改关联视频 */
        $this->goods_movie_db->delete(array(
            'gid' => $id
        ));
        foreach ($movie as $mid) {
            $this->goods_movie_db->insert(array(
                'gid' => $id,
                'mid' => $mid
            ));
        }
        /* 修改关联分组 */
        $this->goods_group_db->delete(array(
            'gid' => $id
        ));
        $group = explode(" - ", $group);
        $this->goods_group_db->insert(array(
            'gid' => $id,
            'cid' => $group[0],
            'vid' => $group[1]
        ));
        /* 修改关联分类 */
        $this->goods_classify_db->delete(array(
            'gid' => $id
        ));
        foreach ($classify as $cid => $vid) {
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
        _return_code(200, "success", "操作成功");
    }

    /**
     * 商品删除
     *
     * @param
     *            id 商品编号
     */
    function delete()
    {
        $id = $_POST['id'];
        if (empty($id)) {
            _return_code(- 1, "error", "请填写商品编号");
        }
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
        _return_code(200, "success", "操作成功");
    }

    /**
     * 商品获取（单个）
     *
     * @param
     *            id 商品编号
     */
    function get()
    {
        $id = $_POST['id'];
        if (empty($id)) {
            _return_code(- 1, "error", "请填写商品编号");
        }
        $goods = $this->goods_db->get_one(array(
            'id' => $id
        ));
        $goods['thumblist'] = json_decode($goods['thumblist']);
        /* 获取关联视频 */
        $movie = $this->goods_movie_db->listinfo(array(
            'gid' => $id
        ));
        $movies = array();
        foreach ($movie as $row) {
            $movies[] = $this->movie_db->get_one(array(
                'id' => $row['mid']
            ));
        }
        /* 获取关联分组 */
        $group = $this->goods_group_db->get_one(array(
            'gid' => $id
        ));
        if ($group['vid'] == 0) {
            $group = $this->group_db->get_one(array(
                'id' => $group['cid']
            ));
        } else {
            $group = $this->group_classify_db->get_one(array(
                'id' => $group['vid']
            ));
        }
        /* 获取关联分类 */
        $classifys = $this->classify_db->listinfo();
        for ($i = 0; $i < count($classifys); $i ++) {
            $values = $this->goods_classify_db->listinfo(array(
                'gid' => $id,
                'cid' => $classifys[$i]['id']
            ));
            foreach ($values as $row) {
                $classifys[$i]['selected'][] = $this->classify_value_db->get_one(array(
                    'id' => $row['vid']
                ));
            }
        }
        _return_data(200, "success", "操作成功", array(
            'goods' => $goods,
            'group' => $group,
            'movies' => $movies,
            'classifys' => $classifys
        ));
    }

    /**
     * 商品获取（全部）
     *
     * @param
     *            uid 用户编号
     * @param
     *            mode 商品模式 [1:普通商品|2:拼团商品|3:砍价商品]
     * @param
     *            free 商品类型 [1:免费商品|-1:付费商品]
     * @param
     *            sale 商品状态 [1:上架商品|-1:下架商品]
     * @param
     *            title 商品标题
     * @param
     *            min_price 最低售价
     * @param
     *            max_price 最高售价
     * @param
     *            min_count 最低销量
     * @param
     *            max_count 最高销量
     * @param
     *            page 当前页码
     * @param
     *            pagesize 显示数目
     */
    function getAll()
    {
        $where = "";
        $order = "";
        $mode = $_POST['mode'];
        $free = $_POST['free'];
        $sale = $_POST['sale'];
        $title = $_POST['title'];
        $min_price = $_POST['min_price'];
        $max_price = $_POST['max_price'];
        $min_count = $_POST['min_count'];
        $max_count = $_POST['max_count'];
        $page = $_POST['page'] ? $_POST['page'] : 1;
        $pagesize = $_POST['pagesize'] ? $_POST['pagesize'] : 20;
        $uid = $_POST['uid'] ? $_POST['uid'] : param::get_cookie("_userid");
        if (empty($uid)) {
            _return_code(- 1, "error", "请填写用户编号");
        }
        $where .= "uid = {$uid} AND ";
        if (! empty($mode)) {
            $where .= "mode = {$mode} AND ";
        }
        if (! empty($free)) {
            $where .= "free = {$free} AND ";
        }
        if (! empty($sale)) {
            $where .= "sale = {$sale} AND ";
        }
        if (! empty($title)) {
            $where .= "title LIKE '%{$title}%' AND ";
        }
        if (! empty($min_price)) {
            $where .= "real_price >= {$min_price} AND ";
        }
        if (! empty($max_price)) {
            $where .= "real_price <= {$max_price} AND ";
        }
        if (! empty($min_count)) {
            $where .= "count >= {$min_count} AND ";
        }
        if (! empty($max_count)) {
            $where .= "count <= {$max_count} AND ";
        }
        $goodss = $this->goods_db->listinfo($where .= 1, $order, $page, $pagesize);
        for ($i = 0; $i < count($goodss); $i ++) {
            $goodss[$i]['thumblist'] = json_decode($goodss[$i]['thumblist']);
        }
        $pages['page'] = $page;
        $pages['pagesize'] = $pagesize;
        $pages['totalnum'] = $this->goods_db->count($where .= 1);
        $pages['totalpage'] = ceil($pages['totalnum'] / $pagesize);
        _return_data(200, "success", "操作成功", array(
            'goodss' => $goodss,
            'pages' => $pages
        ));
    }

    /**
     * 状态更新
     *
     * @param
     *            id 商品编号
     * @param
     *            sale 商品状态 [1:上架商品|-1:下架商品]
     */
    function status()
    {
        $id = $_POST['id'];
        $sale = $_POST['sale'];
        if (empty($id)) {
            _return_code(- 1, "error", "请填写商品编号");
        }
        if (empty($sale)) {
            _return_code(- 2, "error", "请填写商品状态");
        }
        $this->goods_db->update(array(
            'sale' => $sale
        ), array(
            'id' => $id
        ));
        _return_code(200, "success", "操作成功");
    }

    /**
     * 销量更新
     *
     * @param
     *            id 商品编号
     * @param
     *            count 商品数目
     */
    function count()
    {
        $id = $_POST['id'];
        $count = $_POST['count'];
        if (empty($id)) {
            _return_code(- 1, "error", "请填写商品编号");
        }
        if (empty($count)) {
            _return_code(- 2, "error", "请填写商品数目");
        }
        $count += $this->goods_db->get_one(array(
            'id' => $id
        ))['count'];
        $this->goods_db->update(array(
            'count' => $count
        ), array(
            'id' => $id
        ));
        _return_code(200, "success", "操作成功");
    }

    /**
     * 分类获取
     *
     * @param
     *            id 商品编号
     */
    function classify()
    {
        $id = $_POST['id'];
        $classifys = $this->classify_db->listinfo();
        for ($i = 0; $i < count($classifys); $i ++) {
            $classifys[$i]['values'] = $this->classify_value_db->listinfo(array(
                'cid' => $classifys[$i]['id']
            ));
            if (! empty($id)) {
                $values = $this->goods_classify_db->listinfo(array(
                    'gid' => $id,
                    'cid' => $classifys[$i]['id']
                ));
                foreach ($values as $row) {
                    $classifys[$i]['selected'][] = $this->classify_value_db->get_one(array(
                        'id' => $row['vid']
                    ));
                }
            }
        }
        _return_data(200, "success", "操作成功", array(
            'classifys' => $classifys
        ));
    }

    /**
     * 分组添加
     *
     * @param
     *            group[uid] 用户编号
     * @param
     *            group[name] 分组名称
     */
    function add_group()
    {
        $group = $_POST['group'];
        $group['uid'] = $group['uid'] ? $group['uid'] : param::get_cookie("_userid");
        if (empty($group['uid']) || empty($group['name'])) {
            _return_code(- 1, "error", "请填写完整分组参数");
        }
        $this->group_db->insert($group);
        _return_code(200, "success", "操作成功");
    }

    /**
     * 分组删除
     *
     * @param
     *            id 分组编号
     */
    function delete_group()
    {
        $id = $_POST['id'];
        if (empty($id)) {
            _return_code(- 1, "error", "请填写分组编号");
        }
        $this->group_db->delete(array(
            'id' => $id
        ));
        /* 删除关联数据 */
        $this->group_classify_db->delete(array(
            'cid' => $id
        ));
        $this->goods_group_db->delete(array(
            'cid' => $id
        ));
        _return_code(200, "success", "操作成功");
    }

    /**
     * 分组-分类添加
     *
     * @param
     *            classify[cid] 分组编号
     * @param
     *            classify[name] 分类名称
     */
    function add_classify()
    {
        $classify = $_POST['classify'];
        if (empty($classify['cid']) || empty($classify['name'])) {
            _return_code(- 1, "error", "请填写完整分类参数");
        }
        $this->group_classify_db->insert($classify);
        _return_code(200, "success", "操作成功");
    }

    /**
     * 分类删除
     *
     * @param
     *            id 分类编号
     */
    function delete_classify()
    {
        $id = $_POST['id'];
        if (empty($id)) {
            _return_code(- 1, "error", "请填写分类编号");
        }
        $this->group_classify_db->delete(array(
            'id' => $id
        ));
        /* 删除关联数据 */
        $this->goods_group_db->delete(array(
            'vid' => $id
        ));
        _return_code(200, "success", "操作成功");
    }

    /**
     * 分组获取
     *
     * @param
     *            uid 用户编号
     * @param
     *            all 获取分类 [boolean]
     */
    function group()
    {
        $uid = $_POST['uid'] ? $_POST['uid'] : param::get_cookie("_userid");
        if (empty($uid)) {
            _return_code(- 1, "error", "请填写用户编号");
        }
        $groups = $this->group_db->listinfo(array(
            'uid' => $uid
        ));
        if ($_POST['all']) {
            for ($i = 0; $i < count($groups); $i ++) {
                $groups[$i]['classifys'] = $this->group_classify_db->listinfo(array(
                    'cid' => $groups[$i]['id']
                ));
            }
        }
        _return_data(200, "success", "操作成功", array(
            'groups' => $groups
        ));
    }

    /**
     * 文件上传
     */
    function upload()
    {
        $path = dirname(dirname(dirname(__DIR__))) . "/upload/goods";
        $filename = siteurl(get_siteid()) . "/upload/goods/" . pathinfo(upload($_FILES['file'], $path), PATHINFO_BASENAME);
        _return_data(200, "success", "操作成功", array(
            'filename' => $filename
        ));
    }
}