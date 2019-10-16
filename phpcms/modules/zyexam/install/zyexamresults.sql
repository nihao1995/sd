-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2019-08-13 01:47:07
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
-- 表的结构 `zy_zyexamresults`
--

CREATE TABLE IF NOT EXISTS `zy_zyexamresults` (
  `ERID` int(11) NOT NULL AUTO_INCREMENT,
  `EID` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `questionCount` smallint(6) NOT NULL,
  `rightCount` smallint(6) NOT NULL,
  `rightID` text CHARACTER SET utf8mb4 NOT NULL COMMENT '正确序号',
  `errorCount` smallint(6) NOT NULL,
  `errorID` text CHARACTER SET utf8mb4 NOT NULL COMMENT '错误ID和选择',
  `startTime` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `EndTime` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `examResults` float NOT NULL,
  `signature` varchar(255) CHARACTER SET utf8mb4 NOT NULL COMMENT '签名',
  PRIMARY KEY (`ERID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='考试成绩表' AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `zy_zyexamresults`
--

INSERT INTO `zy_zyexamresults` (`ERID`, `EID`, `userid`, `questionCount`, `rightCount`, `rightID`, `errorCount`, `errorID`, `startTime`, `EndTime`, `examResults`, `signature`) VALUES
(1, 12, 29, 12, 2, '["singlechoice9","singlechoice11"]', 10, '{"trueorfalsechoice2":"1","multiplechoice131":"C","multiplechoice6":"A","multiplechoice2":"C","multiplechoice1":"ACD","singlechoice12":"B","trueorfalsechoice4":"1","trueorfalsechoice3":"1","singlechoice1":"D","multiplechoice5":"BC"}', '2019-07-27 10:53:54', '2019-07-27 10:54:36', 16.67, 'http://js2.300c.cn/zaixianxuexi//uploadfile/headimg/20190727/1564196085.png'),
(2, 12, 28, 12, 3, '["singlechoice1","trueorfalsechoice2","singlechoice11"]', 9, '{"singlechoice9":"D","multiplechoice131":"A","trueorfalsechoice3":"1","singlechoice12":"B","trueorfalsechoice4":"1","multiplechoice1":"ABC","multiplechoice6":"AD","multiplechoice5":"ABC","multiplechoice2":"BC"}', '2019-07-30 14:04:24', '2019-07-30 14:05:07', 25, 'http://js2.300c.cn/zaixianxuexi//uploadfile/headimg/20190730/1564466717.png'),
(4, 13, 29, 15, 4, '["trueorfalsechoice7","trueorfalsechoice4","singlechoice12","trueorfalsechoice13"]', 11, '{"singlechoice1652":"C","singlechoice787":"B","multiplechoice2":"B","multiplechoice46":"CD","rankchoice1":"CDEBA","singlechoice781":"B","multiplechoice121":"ABD","singlechoice1648":"B","singlechoice780":"D","singlechoice778":"A","multiplechoice7":"BC"}', '2019-07-31 14:22:59', '2019-07-31 14:23:31', 26.67, 'http://js2.300c.cn/zaixianxuexi//uploadfile/headimg/20190731/1564554215.png'),
(5, 13, 1, 15, 5, '["singlechoice778","trueorfalsechoice4","trueorfalsechoice7","singlechoice12","singlechoice780"]', 10, '{"singlechoice787":"A","multiplechoice7":"AB","multiplechoice121":"D","multiplechoice2":"D","singlechoice781":"D","singlechoice1652":"A","rankchoice1":"EADBC","singlechoice1648":"B","trueorfalsechoice13":"0","multiplechoice46":"AD"}', '2019-08-01 09:09:34', '2019-08-01 09:10:22', 33.33, 'http://js2.300c.cn/zaixianxuexi//uploadfile/headimg/20190801/1564621837.png'),
(6, 14, 29, 1, 0, '[]', 1, '{"multiplechoice15":"BD"}', '2019-08-05 10:27:56', '2019-08-05 10:28:08', 0, 'http://js2.300c.cn/zaixianxuexi//uploadfile/headimg/20190805/1564972092.png'),
(7, 14, 29, 1, 0, '[]', 1, '{"multiplechoice15":""}', '2019-08-05 10:31:32', '2019-08-05 10:31:43', 0, 'http://js2.300c.cn/zaixianxuexi//uploadfile/headimg/20190805/1564972308.png'),
(8, 15, 29, 20, 4, '["singlechoice13","trueorfalsechoice7","trueorfalsechoice8","singlechoice14"]', 16, '{"trueorfalsechoice9":"0","trueorfalsechoice2":"1","singlechoice9":"B","multiplechoice1":"D","singlechoice11":"B","singlechoice1":"D","multiplechoice10":"D","multiplechoice8":"D","multiplechoice6":"A","multiplechoice7":"D","trueorfalsechoice4":"1","singlechoice12":"D","multiplechoice2":"D","multiplechoice5":"A","trueorfalsechoice5":"0","trueorfalsechoice3":"1"}', '2019-08-10 16:09:45', '2019-08-10 16:10:46', 20, 'http://js2.300c.cn/zaixianxuexi//uploadfile/headimg/20190810/1565424670.png'),
(9, 15, 28, 20, 6, '["trueorfalsechoice2","trueorfalsechoice7","singlechoice11","trueorfalsechoice5","singlechoice1","trueorfalsechoice9"]', 14, '{"multiplechoice1":"C","multiplechoice8":"A","multiplechoice5":"A","trueorfalsechoice8":"1","multiplechoice2":"A","singlechoice12":"B","trueorfalsechoice3":"1","multiplechoice7":"B","trueorfalsechoice4":"1","singlechoice9":"B","multiplechoice10":"C","singlechoice14":"C","singlechoice13":"D","multiplechoice6":"B"}', '2019-08-10 16:19:16', '2019-08-10 16:20:38', 30, 'http://js2.300c.cn/zaixianxuexi//uploadfile/headimg/20190810/1565425346.png');



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
