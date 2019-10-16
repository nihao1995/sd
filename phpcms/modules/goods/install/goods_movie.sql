DROP TABLE IF EXISTS `zy_goods_movie`;
CREATE TABLE `zy_goods_movie` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水编号',
  `gid` int(11) DEFAULT NULL COMMENT '商品编号',
  `mid` int(11) DEFAULT NULL COMMENT '视频编号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
