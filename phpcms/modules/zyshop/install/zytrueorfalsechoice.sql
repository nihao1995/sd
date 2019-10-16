-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2019-08-13 01:46:32
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
-- 表的结构 `zy_zytrueorfalsechoice`
--

CREATE TABLE IF NOT EXISTS `zy_zytrueorfalsechoice` (
  `TFCID` int(11) NOT NULL AUTO_INCREMENT COMMENT '多选题ID',
  `itemname` varchar(245) NOT NULL COMMENT '题目',
  `answer` varchar(11) NOT NULL COMMENT '答案(1正确，0错误)',
  `provenance` varchar(255) NOT NULL COMMENT '出处',
  `clause` varchar(255) NOT NULL COMMENT '条目',
  `category` varchar(255) NOT NULL COMMENT '类别（安全，规章，预案，标准，等）',
  `difficulty` varchar(255) NOT NULL COMMENT '难易(高：3中：2低：1)',
  `choiceType` varchar(111) NOT NULL DEFAULT 'trueorfalsechoice' COMMENT '题型',
  `glry` smallint(6) NOT NULL DEFAULT '0' COMMENT '管理人员(1:是0：否)',
  `khfwy` smallint(6) NOT NULL DEFAULT '0' COMMENT '客户服务员(1:是0：否)',
  `kyy` smallint(6) NOT NULL DEFAULT '0' COMMENT '客运员',
  `kyzby` smallint(6) NOT NULL DEFAULT '0' COMMENT '客运值班员',
  `spy` smallint(6) NOT NULL DEFAULT '0' COMMENT '售票员',
  `jhy` smallint(6) NOT NULL DEFAULT '0' COMMENT '计划员',
  `spzby` smallint(6) NOT NULL DEFAULT '0' COMMENT '售票值班员',
  `lcz` smallint(6) NOT NULL DEFAULT '0' COMMENT '列车长',
  `lcy` smallint(6) NOT NULL DEFAULT '0' COMMENT '列车员',
  `lczby` smallint(6) NOT NULL DEFAULT '0' COMMENT '列车值班员',
  `xly` smallint(6) NOT NULL DEFAULT '0' COMMENT '行李员',
  `xlzby` smallint(6) NOT NULL DEFAULT '0' COMMENT '行李值班员',
  `kfzky` smallint(6) NOT NULL DEFAULT '0' COMMENT '客服综控员',
  `gsy` smallint(6) NOT NULL DEFAULT '0' COMMENT '给水员',
  `ccz` smallint(6) NOT NULL DEFAULT '0' COMMENT '餐车长',
  `answerCount` int(11) NOT NULL DEFAULT '0',
  `ErrorCount` int(11) NOT NULL DEFAULT '0',
  `videourl` varchar(255) NOT NULL,
  `photourl` varchar(255) NOT NULL,
  PRIMARY KEY (`TFCID`),
  UNIQUE KEY `itemname` (`itemname`),
  FULLTEXT KEY `provenance` (`provenance`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COMMENT='判断题' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `zy_zytrueorfalsechoice`
--

INSERT INTO `zy_zytrueorfalsechoice` (`TFCID`, `itemname`, `answer`, `provenance`, `clause`, `category`, `difficulty`, `choiceType`, `glry`, `khfwy`, `kyy`, `kyzby`, `spy`, `jhy`, `spzby`, `lcz`, `lcy`, `lczby`, `xly`, `xlzby`, `kfzky`, `gsy`, `ccz`, `answerCount`, `ErrorCount`, `videourl`, `photourl`) VALUES
(1, '全国通用乘车证除可手工输入证件号码外，还可扫描全国通用乘车证上的二维码自动读取证件信息。', '1', '《窗口核验及免票信息查询》', '', '安全', '低', 'trueorfalsechoice', 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, '', ''),
(2, '持软席、硬席的单程或往返乘车证，除换乘外中途下车有效。', '0', '《铁路乘车证管理办法》（铁劳〔1994〕142号）', '第二章第三条', '安全', '低', 'trueorfalsechoice', 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, '', ''),
(3, '持用临时定期、软席、硬席、探亲乘车证时，可免于签证。', '0', '《铁路乘车证管理办法》（铁劳〔1994〕142号）', '第十一章第五条', '安全', '低', 'trueorfalsechoice', 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, '', ''),
(4, '持用全年定期、临时定期、软席、硬席乘车证和便乘证，在正式或临时营业铁路上准乘各种旅客列车.', '0', '《铁路乘车证管理办法》（铁劳〔1994〕142号）', '第十一章第三十一条', '安全', '低', 'trueorfalsechoice', 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, '', ''),
(5, '持用全年定期、通勤、定期就医乘车证可免于签证。', '1', '《铁路乘车证管理办法》（铁劳〔1994〕142号）', '第十一章第五条', '安全', '低', 'trueorfalsechoice', 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, '', ''),
(6, '持用探亲乘车证，不能托运行李、搬家物品等。', '0', '《铁路乘车证管理办法》（铁劳〔1994〕142号）', '第十一章第三十一条', '安全', '低', 'trueorfalsechoice', 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, '', ''),
(7, '持用铁路各种乘车证，均不能免费托运行李、搬家物品等.', '1', '《铁路乘车证管理办法》（铁劳〔1994〕142号）', '第十一章第三十一条', '安全', '低', 'trueorfalsechoice', 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, '', ''),
(8, '各种铁路乘车证，每张只限填发一个到站。', '0', '《铁路乘车证管理办法》（铁劳〔1994〕142号）', '第十一章第三十条', '安全', '低', 'trueorfalsechoice', 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, '', ''),
(9, '临时定期乘车证一次出差到一条线的几个站，可填到最远站.', '1', '《铁路乘车证管理办法》（铁劳〔1994〕142号）', '第二章第七条', '安全', '低', 'trueorfalsechoice', 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, '', ''),
(10, '探亲乘车证不能乘坐软席和免费使用卧铺。', '1', '《铁路乘车证管理办法》（铁劳〔1994〕142号）', '第七章第二十条', '安全', '低', 'trueorfalsechoice', 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, '', '');



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
