DROP TABLE IF EXISTS `zy_goods`;
CREATE TABLE `zy_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品编号',
  `uid` int(11) DEFAULT NULL COMMENT '用户编号',
  `mode` int(11) DEFAULT NULL COMMENT '商品模式 [1:普通商品|2:拼团商品|3:砍价商品]',
  `free` int(11) DEFAULT NULL COMMENT '商品类型 [1:免费商品|-1:付费商品]',
  `sale` int(11) DEFAULT NULL COMMENT '商品状态 [1:上架商品|-1:下架商品]',
  `title` varchar(255) DEFAULT NULL COMMENT '商品标题',
  `content` varchar(255) DEFAULT NULL COMMENT '商品简介',
  `thumb` varchar(255) DEFAULT NULL COMMENT '商品缩略图',
  `thumblist` text COMMENT '商品详情图',
  `real_price` decimal(10,2) DEFAULT NULL COMMENT '商品零售价',
  `fake_price` decimal(10,2) DEFAULT NULL COMMENT '商品市场价',
  `group_price` decimal(10,2) DEFAULT NULL COMMENT '商品拼团价',
  `uploadtime` int(11) DEFAULT NULL COMMENT '上传时间',
  `updatetime` int(11) DEFAULT NULL COMMENT '修改时间',
  `count` int(11) DEFAULT '0' COMMENT '商品销量',
  `type` int(11) DEFAULT NULL COMMENT '优惠类型 [1:拼团价|2:拼团折扣]',
  `number` int(11) DEFAULT NULL COMMENT '拼团人数',
  `discount` double DEFAULT NULL COMMENT '拼团折扣',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
