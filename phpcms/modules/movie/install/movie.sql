DROP TABLE IF EXISTS `zy_movie`;
CREATE TABLE `zy_movie` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '视频编号',
  `uid` int(11) DEFAULT NULL COMMENT '用户编号',
  `title` varchar(255) DEFAULT NULL COMMENT '视频标题',
  `thumb` varchar(255) DEFAULT NULL COMMENT '视频图片',
  `filename` varchar(255) DEFAULT NULL COMMENT '视频文件',
  `uploadtime` int(11) DEFAULT NULL COMMENT '上传时间',
  `updatetime` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
