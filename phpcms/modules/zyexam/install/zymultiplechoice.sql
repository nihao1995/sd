-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2019-08-13 01:46:52
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
-- 表的结构 `zy_zymultiplechoice`
--

CREATE TABLE IF NOT EXISTS `zy_zymultiplechoice` (
  `MCID` int(11) NOT NULL AUTO_INCREMENT COMMENT '多选题ID',
  `itemname` varchar(245) NOT NULL COMMENT '题目',
  `options` varchar(255) NOT NULL COMMENT '选项（JSON）',
  `answer` varchar(11) NOT NULL COMMENT '答案',
  `provenance` varchar(255) NOT NULL COMMENT '出处',
  `clause` varchar(255) NOT NULL COMMENT '条目',
  `category` varchar(255) NOT NULL COMMENT '类别（安全，规章，预案，标准，等）',
  `difficulty` varchar(255) NOT NULL COMMENT '难易(高：3中：2低：1)',
  `choiceType` varchar(111) NOT NULL DEFAULT 'multiplechoice' COMMENT '题型',
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
  PRIMARY KEY (`MCID`),
  UNIQUE KEY `itemname` (`itemname`),
  FULLTEXT KEY `provenance` (`provenance`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COMMENT='多选题' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `zy_zymultiplechoice`
--

INSERT INTO `zy_zymultiplechoice` (`MCID`, `itemname`, `options`, `answer`, `provenance`, `clause`, `category`, `difficulty`, `choiceType`, `glry`, `khfwy`, `kyy`, `kyzby`, `spy`, `jhy`, `spzby`, `lcz`, `lcy`, `lczby`, `xly`, `xlzby`, `kfzky`, `gsy`, `ccz`, `answerCount`, `ErrorCount`, `videourl`, `photourl`) VALUES
(1, '（  ）是合同或者合同的组成部分。', '{"A":"旅客车票","B":"行李票","C":"包裹票","D":"货物运单"}', 'ABCD', '中华人民共和国铁路法', '第十一条', '安全', '低', 'multiplechoice', 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, '', ''),
(2, '（  ）是特定运价。', '{"A":"包车费","B":"租车费","C":"挂运费","D":"行驶费"}', 'ABCD', '铁路客运运价规则', '第二十五条', '安全', '低', 'multiplechoice', 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, '', ''),
(3, '《铁路旅客运输管理规则》第七十五条规定，公文交接要坚持确认到站，检查封印、包装，清点件数的制度，一般公文按到站分存,（  ）应加锁保管。', '{"A":"贵重品","B":"普通文件","C":"中途站","D":"保密文件"}', 'AD', '铁路旅客运输管理规则', '第75条', '安全', '低', 'multiplechoice', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, '', ''),
(4, ' 车辆按照用途分为客车、（  ）。', '{"A":"试验车","B":"发电车","C":"货车","D":"特种用途车"}', 'CD', '铁路技术管理规程（普速铁路部分）', '第177条', '安全', '低', 'multiplechoice', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 0, 0, '', ''),
(5, '乘务组的主要工作是（  ）。', '{"A":"使车内经常保持整齐清洁、设备良好、温度适宜、照明充足","B":"通告站名，组织旅客安全乘降，及时妥善安排旅客座席、铺位","C":"对老、幼、病、残、孕等重点旅客做到重点照顾","D":"维护车内秩序，保证安全正点；做好饮食供应工作"}', 'ABCD', '铁路旅客运输管理规则', '第65条', '安全', '低', 'multiplechoice', 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 1, 0, 0, '', ''),
(6, ' 当向查找站转送旅客遗留在车站、车内的携带品时，（  ）不办理转送。', '{"A":"危险品","B":"国家禁止或限制运输的物品","C":"动物","D":"食品"}', 'ABCD', '铁路旅客运输规程', '第五十二、五十六条', '安全', '低', 'multiplechoice', 0, 0, 1, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, '', ''),
(7, ' 电话订票系统中使用的旅客身份证件为：（  ）。', '{"A":"中华人民共和国居民使用中华人民共和国居民身份证","B":"台湾居民使用台湾居民来往大陆通行证","C":"港澳居民使用港澳居民来往内地通行证","D":"外国人使用护照"}', 'ABCD', '《济南铁路局电话订票组织管理办法》(济铁客发〔2011〕376号)', '第十五条', '安全', '低', 'multiplechoice', 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, '', ''),
(8, '对旅客的遗失物品应设法归还原主。如旅客已经下车，应编制客运记录，注明（  ）等移交下车站。', '{"A":"数量","B":"品名","C":"重量","D":"件数"}', 'BD', '铁路旅客运输规程', '第五十五条', '安全', '低', 'multiplechoice', 0, 0, 1, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, '', ''),
(9, ' 对无法交付的行李、包裹和旅客的遗失物品、暂存物品，承运人应（  ）。', '{"A":"登记造册","B":"妥善保管","C":"按时保管","D":"不得动用"}', 'ABD', '铁路旅客运输规程', '第九十五条', '安全', '低', 'multiplechoice', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, '', ''),
(10, '发售代用票应按规定填写，填写事由栏时，规定略语“不符”是指（  ）.', '{"A":"不符合乘车日期","B":"不符合乘车车次","C":"不符合乘车径路","D":"不符合减价规定"}', 'ABC', '铁路旅客运输办理细则', '第二十三条', '安全', '低', 'multiplechoice', 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, '', '');