DROP TABLE IF EXISTS `zy_classify`;
CREATE TABLE `zy_classify` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类编号',
  `name` varchar(255) DEFAULT NULL COMMENT '分类名称',
  `type` int(11) DEFAULT NULL COMMENT '分类类型 [1:选择|2:多选|3:单选]',
  `vital` int(11) DEFAULT NULL COMMENT '是否必填',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
