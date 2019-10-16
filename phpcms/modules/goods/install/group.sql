DROP TABLE IF EXISTS `zy_group`;
CREATE TABLE `zy_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分组编号',
  `uid` int(11) DEFAULT NULL COMMENT '用户编号',
  `name` varchar(255) DEFAULT NULL COMMENT '分组名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
