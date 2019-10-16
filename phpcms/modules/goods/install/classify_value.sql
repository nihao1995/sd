DROP TABLE IF EXISTS `zy_classify_value`;
CREATE TABLE `zy_classify_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '属性编号',
  `cid` int(11) DEFAULT NULL COMMENT '所属分类',
  `name` varchar(255) DEFAULT NULL COMMENT '属性名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
