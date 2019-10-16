-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2019-08-13 01:46:45
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
-- 表的结构 `zy_zyrankchoice`
--

CREATE TABLE IF NOT EXISTS `zy_zyrankchoice` (
  `RCID` int(11) NOT NULL AUTO_INCREMENT COMMENT '多选题ID',
  `itemname` varchar(245) NOT NULL COMMENT '题目',
  `options` varchar(255) NOT NULL COMMENT '选项（JSON）',
  `answer` varchar(11) NOT NULL COMMENT '答案',
  `provenance` varchar(255) NOT NULL COMMENT '出处',
  `clause` varchar(255) NOT NULL COMMENT '条目',
  `category` varchar(255) NOT NULL COMMENT '类别（安全，规章，预案，标准，等）',
  `difficulty` varchar(255) NOT NULL COMMENT '难易(高：3中：2低：1)',
  `choiceType` varchar(111) NOT NULL DEFAULT 'rankchoice' COMMENT '题型',
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
  `answerCount` int(11) NOT NULL DEFAULT '0' COMMENT '回答次数',
  `ErrorCount` int(11) NOT NULL DEFAULT '0' COMMENT '错误次数',
  `videourl` varchar(255) NOT NULL,
  `photourl` varchar(255) NOT NULL,
  PRIMARY KEY (`RCID`),
  UNIQUE KEY `itemname` (`itemname`),
  FULLTEXT KEY `provenance` (`provenance`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COMMENT='多选题' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `zy_zyrankchoice`
--

INSERT INTO `zy_zyrankchoice` (`RCID`, `itemname`, `options`, `answer`, `provenance`, `clause`, `category`, `difficulty`, `choiceType`, `glry`, `khfwy`, `kyy`, `kyzby`, `spy`, `jhy`, `spzby`, `lcz`, `lcy`, `lczby`, `xly`, `xlzby`, `kfzky`, `gsy`, `ccz`, `answerCount`, `ErrorCount`, `videourl`, `photourl`) VALUES
(1, '这是排序题', '{"A":" 1","B":" 2","C":" 3","D":" 4","E":" 5"}', 'EABCD', '123', '41', '4', '高', 'rankchoice', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 19, 18, '', ''),
(3, '一个客户', '{"A":"1","B":"2","C":"3","D":"4"}', 'ABCD', '1234678', '41', '142', '高', 'rankchoice', 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '');



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
