-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2019-08-13 01:46:39
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
-- 表的结构 `zy_zysinglechoice`
--

CREATE TABLE IF NOT EXISTS `zy_zysinglechoice` (
  `SCID` int(11) NOT NULL AUTO_INCREMENT COMMENT '单选题ID',
  `itemname` varchar(245) NOT NULL COMMENT '题目',
  `options` varchar(255) NOT NULL COMMENT '选项（JSON）',
  `answer` varchar(11) NOT NULL COMMENT '答案',
  `provenance` varchar(255) NOT NULL COMMENT '出处',
  `clause` varchar(255) NOT NULL COMMENT '条目',
  `category` varchar(255) NOT NULL COMMENT '类别（安全，规章，预案，标准，等）',
  `difficulty` varchar(255) NOT NULL COMMENT '难易(高：3中：2低：1)',
  `choiceType` varchar(111) NOT NULL DEFAULT 'singlechoice' COMMENT '题型',
  `glry` smallint(6) NOT NULL DEFAULT '0' COMMENT '管理人员(1:是0：否)',
  `khfwy` smallint(6) NOT NULL DEFAULT '0' COMMENT '客户服务员(1:是0：否)',
  `kyy` smallint(6) NOT NULL DEFAULT '0' COMMENT '客运员',
  `kyzby` smallint(6) NOT NULL DEFAULT '0' COMMENT '客运值班员',
  `spy` smallint(6) NOT NULL DEFAULT '0' COMMENT '售票员',
  `jhy` smallint(12) NOT NULL DEFAULT '0' COMMENT '计划员',
  `spzby` smallint(6) NOT NULL DEFAULT '0' COMMENT '售票值班员',
  `lcz` smallint(6) NOT NULL DEFAULT '0' COMMENT '列车长',
  `lcy` smallint(6) NOT NULL DEFAULT '0' COMMENT '列车员',
  `lczby` smallint(6) NOT NULL DEFAULT '0' COMMENT '列车值班员',
  `xly` smallint(6) NOT NULL DEFAULT '0' COMMENT '行李员',
  `xlzby` smallint(6) NOT NULL DEFAULT '0' COMMENT '行李值班员',
  `kfzky` smallint(6) NOT NULL DEFAULT '0' COMMENT '客服综控员',
  `gsy` smallint(6) NOT NULL DEFAULT '0' COMMENT '给水员',
  `ccz` smallint(6) NOT NULL DEFAULT '0' COMMENT '餐车长',
  `answerCount` int(11) NOT NULL DEFAULT '0' COMMENT '回答总次数',
  `ErrorCount` int(11) NOT NULL DEFAULT '0' COMMENT '错误次数',
  `videourl` varchar(255) NOT NULL COMMENT '视频链接',
  `photourl` varchar(255) NOT NULL COMMENT '图片链接',
  PRIMARY KEY (`SCID`),
  UNIQUE KEY `itemname` (`itemname`),
  FULLTEXT KEY `provenance` (`provenance`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COMMENT='单选题' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `zy_zysinglechoice`
--

INSERT INTO `zy_zysinglechoice` (`SCID`, `itemname`, `options`, `answer`, `provenance`, `clause`, `category`, `difficulty`, `choiceType`, `glry`, `khfwy`, `kyy`, `kyzby`, `spy`, `jhy`, `spzby`, `lcz`, `lcy`, `lczby`, `xly`, `xlzby`, `kfzky`, `gsy`, `ccz`, `answerCount`, `ErrorCount`, `videourl`, `photourl`) VALUES
(1, '车站放行旅客前，司机（随车机械师）根据（  ）的通知开门。', '{"A":"列车长","B":"车站值班员","C":"机械师","D":"客运员"}', 'A', '《中国铁路济南局集团有限公司普速铁路行车组织规则》（济铁总发〔2018〕61号），《中国铁路济南局集团有限公司高速铁路行车组织细则》（济铁总发〔2018〕62号）', '第91条、\n第42条', '安全', '低', 'singlechoice', 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 2, 1, '', ''),
(2, ' 在行包运输作业过程中，需要编制（  ）时，可使用系统编制。', '{"A":"电报","B":"交接证","C":"客运记录","D":"行包运输方案"}', 'C', '《路局客运处关于公布〈“铁路行包事故处理信息系统”运用管理实施细则（试行）〉的通知》（济铁总发〔2014〕326号）', '\n第十八条', '安全', '低', 'singlechoice', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, '', ''),
(3, '《“铁路行包事故处理信息系统”运用管理办法（试行）》中，对定责有误的事故处理单位可在行包事故定责通知书发出后的（  ）内进行修改。', '{"A":"5日","B":"10日","C":"15日","D":"20日"}', 'C', '《路局客运处关于公布〈“铁路行包事故处理信息系统”运用管理实施细则（试行）〉的通知》（济铁总发〔2014〕326号）', '第六条', '安全', '低', 'singlechoice', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, '', ''),
(4, '各单位处理行包事故及行包有关业务需拍发电报的，应通过（  ）完成。', '{"A":"行包事故处理信息系统","B":"电报所","C":"行包信息系统","D":"数据上报模块"}', 'A', '《路局客运处关于公布〈“铁路行包事故处理信息系统”运用管理实施细则（试行）〉的通知》（济铁总发〔2014〕326号）', '第十七条', '安全', '低', 'singlechoice', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, '', ''),
(5, '根据行包事故调查程序，立案单位须通过铁路行包事故处理信息系统向相关单位发出（  ）。', '{"A":"查询电报","B":"事故查复书","C":"行包事故记录","D":"事故定责通知书"}', 'B', '《路局客运处关于公布〈“铁路行包事故处理信息系统”运用管理实施细则（试行）〉的通知》（济铁总发〔2014〕326号）', '第二十二条', '安全', '低', 'singlechoice', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, '', ''),
(6, '行包事故处理信息系统发生故障，无法正常使用时，可（  ）处理，有关纸质资料待系统恢复后进行补录补传。', '{"A":"暂缓","B":"采用手工方式","C":"采用非电子办公方式","D":"协商"}', 'C', '《路局客运处关于公布〈“铁路行包事故处理信息系统”运用管理实施细则（试行）〉的通知》（济铁总发〔2014〕326号）', '第二十一条', '安全', '低', 'singlechoice', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, '', ''),
(7, '行包事故处理信息系统生成的电报、记录、查复书等案卷信息是事故赔偿、责任划分的重要依据，任何单位和个人不得（  ）。', '{"A":"弄虚作假","B":"虚报瞒报","C":"擅自修改和删除","D":"丢失毁损"}', 'C', '《路局客运处关于公布〈“铁路行包事故处理信息系统”运用管理实施细则（试行）〉的通知》（济铁总发〔2014〕326号）', '第二十条', '安全', '低', 'singlechoice', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, '', ''),
(8, '铁路行包事故处理信息系统运用管理办法（试行）自（  ）起施行。', '{"A":"41760","B":"42125","C":"41791","D":"42156"}', 'A', '《路局客运处关于公布〈“铁路行包事故处理信息系统”运用管理实施细则（试行）〉的通知》（济铁总发〔2014〕326号）', '第三十三条', '安全', '低', 'singlechoice', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, '', ''),
(9, '《安全生产法》规定，生产经营单位必须遵守本法和其他有关安全生产的法律、法规，加强安全生产管理，建立、健全（  ）和安全规章制度，完善安全生产条件，推进安全生产标准化建设，提高安全生产水平，确保安全生产。', '{"A":"安全生产责任制","B":"安全规章制度","C":"安全责任追究制度","D":"安全考核制度"}', 'A', '中华人民共和国安全生产法', '第四条', '安全', '低', 'singlechoice', 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, '', ''),
(10, '《中华人民共和国安全生产法》第二十七条规定，生产经营单位的特种作业人员必须按照国家有关规定经专门的（  ）培训，取得相应资格，方可上岗作业。', '{"A":"安全作业","B":"业务知识","C":"理论知识","D":"作业流程"}', 'A', '中华人民共和国安全生产法', '第二十七条', '安全', '低', 'singlechoice', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, '', '');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
