DROP TABLE IF EXISTS `zy_group_classify`;
CREATE TABLE `zy_group_classify` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类编号',
  `cid` int(11) DEFAULT NULL COMMENT '所属分组',
  `name` varchar(255) DEFAULT NULL COMMENT '分类名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
