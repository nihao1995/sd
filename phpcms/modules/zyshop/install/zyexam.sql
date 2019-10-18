-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2019-08-13 01:47:03
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zaixiankaoshi`
--

-- --------------------------------------------------------

--
-- 表的结构 `zy_zyexam`
--

CREATE TABLE IF NOT EXISTS `zy_zyexam` (
  `EID` int(11) NOT NULL AUTO_INCREMENT,
  `titlename` varchar(255) CHARACTER SET utf8mb4 NOT NULL COMMENT '标题',
  `category` varchar(222) CHARACTER SET utf8mb4 NOT NULL COMMENT '工种',
  `member` text CHARACTER SET utf8mb4 NOT NULL COMMENT '考试成员',
  `SCID` text CHARACTER SET utf8mb4 NOT NULL COMMENT '单选',
  `MCID` text CHARACTER SET utf8mb4 NOT NULL COMMENT '多选',
  `TFCID` text CHARACTER SET utf8mb4 NOT NULL COMMENT '判断',
  `RCID` text CHARACTER SET utf8mb4 NOT NULL,
  `addtime` varchar(222) CHARACTER SET utf8mb4 NOT NULL COMMENT '添加时间',
  `dateStart` varchar(222) CHARACTER SET utf8mb4 NOT NULL COMMENT '考试开始时间',
  `dateEnd` varchar(222) CHARACTER SET utf8mb4 NOT NULL COMMENT '考试结束时间',
  `timestampStart` varchar(222) CHARACTER SET utf8mb4 NOT NULL COMMENT '开始时间戳',
  `timestampEnd` varchar(222) CHARACTER SET utf8mb4 NOT NULL COMMENT '结束时间戳',
  `examTime` varchar(222) CHARACTER SET utf8mb4 NOT NULL COMMENT '考试时长',
  `finishMember` text CHARACTER SET utf8mb4 NOT NULL COMMENT '结束考试用户',
  PRIMARY KEY (`EID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='考试表' AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `zy_zyexam`
--

INSERT INTO `zy_zyexam` (`EID`, `titlename`, `category`, `member`, `SCID`, `MCID`, `TFCID`, `RCID`, `addtime`, `dateStart`, `dateEnd`, `timestampStart`, `timestampEnd`, `examTime`, `finishMember`) VALUES
(12, '列车员考试专栏', 'lczby', '["1","","","27"]', '["1","9","11","12"]', '["1","2","5","6","131"]', '["2","3","4"]', '', '2019-07-26 17:04:06', '2019-07-30 00:00:00', '2019-08-01 00:00:00', '1564416000', '1564588800', '00:05:07', '["29","28"]'),
(13, '大大大', 'lczby', '["","28","27",""]', '["12","778","780","781","787","1648","1652"]', '["2","7","46","121"]', '["4","7","13"]', '["1"]', '2019-07-31 14:01:42', '2019-07-31 00:00:00', '2019-08-02 00:00:00', '1564502400', '1564675200', '02:00:00', '["29","1"]'),
(14, '这份', 'lczby', '["29"]', '', '["15"]', '', '', '2019-08-05 10:27:48', '2019-08-04 00:00:00', '2019-08-06 00:00:00', '1564848000', '1565020800', '00:00:10', '["29","29"]'),
(15, '铁路局-列车值班员', 'lczby', '["1","","","27"]', '["1","9","11","12","13","14"]', '["1","2","5","6","7","8","10"]', '["2","3","4","5","7","8","9"]', '', '2019-08-10 16:09:37', '2019-08-10 00:00:00', '2019-08-31 00:00:00', '1565366400', '1567180800', '01:00:00', '["29","28"]');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
