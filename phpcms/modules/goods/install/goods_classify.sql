DROP TABLE IF EXISTS `zy_goods_classify`;
CREATE TABLE `zy_goods_classify` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水编号',
  `gid` int(11) DEFAULT NULL COMMENT '商品编号',
  `cid` int(11) DEFAULT NULL COMMENT '分类编号',
  `vid` int(11) DEFAULT NULL COMMENT '属性编号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
