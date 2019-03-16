-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2019 年 02 月 13 日 01:44
-- 服务器版本: 5.5.53
-- PHP 版本: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `openjudge`
--

-- --------------------------------------------------------

--
-- 表的结构 `oj_data`
--

CREATE TABLE IF NOT EXISTS `oj_data` (
  `oj_name` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '网站名称',
  `oj_html_title` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '标题',
  `oj_title` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '副名称',
  `oj_runid` int(11) NOT NULL,
  `oj_EvaMacState` int(11) NOT NULL,
  `oj_allrun` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `oj_data`
--

INSERT INTO `oj_data` (`oj_name`, `oj_html_title`, `oj_title`, `oj_runid`, `oj_EvaMacState`, `oj_allrun`) VALUES
('OpenJudge', 'OpenJudge - 评测平台', 'OpenJudge - 评测平台', 56, 1, 258);

-- --------------------------------------------------------

--
-- 表的结构 `oj_problem`
--

CREATE TABLE IF NOT EXISTS `oj_problem` (
  `Name` varchar(20) COLLATE utf8_bin NOT NULL,
  `proNum` int(11) NOT NULL,
  `LimitTime` int(11) NOT NULL,
  `LimitMemory` int(11) NOT NULL,
  `Description` text COLLATE utf8_bin NOT NULL,
  `InputFormat` text COLLATE utf8_bin NOT NULL,
  `OutputFormat` text COLLATE utf8_bin NOT NULL,
  `EmpInput` text COLLATE utf8_bin NOT NULL,
  `EmpOutput` text COLLATE utf8_bin NOT NULL,
  `Hint` text COLLATE utf8_bin NOT NULL,
  `Source` text COLLATE utf8_bin NOT NULL,
  `CreateTime` date NOT NULL,
  `Test` varchar(100) COLLATE utf8_bin NOT NULL,
  `Show` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `oj_problem`
--

INSERT INTO `oj_problem` (`Name`, `proNum`, `LimitTime`, `LimitMemory`, `Description`, `InputFormat`, `OutputFormat`, `EmpInput`, `EmpOutput`, `Hint`, `Source`, `CreateTime`, `Test`, `Show`) VALUES
('A+B Problem', 1000, 1000, 65535, 'Calculate a+b', 'Two integer a and b', 'value of a+b', '1 2', '3', '<div class="panel">C<br/>\r\n<pre class="padding-0"><code class="C">#include &lt;stdio.h&gt;\r\nint main(void)\r\n{\r\n    int a,b;\r\n    scanf("%d%d",&amp;a,&amp;b);\r\n    printf("%d",a+b);\r\n    return 0;\r\n}\r\n</code></pre>\r\n<br/>\r\nC++<br />\r\n<pre class="padding-0"><code class="C++">#include &lt;iostream&gt;\r\nusing namespace std;\r\nint main()\r\n{\r\n    int a,b;\r\n    cin&gt;&gt;a&gt;&gt;b;\r\n    cout&lt;&lt;a+b&lt;&lt;endl;\r\n    return 0;\r\n}</code></pre><br />\r\nJava<br />\r\n<pre><code class="java">import java.util.*;\r\nimport java.io.*;\r\npublic class Main\r\n{\r\n    public static void main(String[] args)\r\n    {\r\n        Scanner reader=new Scanner(System.in);\r\n        int a,b;\r\n        a=reader.nextInt();\r\n        b=reader.nextInt();\r\n        System.out.println(a+b);\r\n    }\r\n}</code>\r\n</pre><br />\r\nPython2.7<br />\r\n<pre><code class="python">import sys\r\nfor line in sys.stdin:\r\n a = line.split() \r\nprint int(a[0]) + int (a[1])\r\n</code></pre><br />\r\n</div>', '', '2019-02-01', '1&2&3&4&5&6&7&8&9', 1),
('Hello, World!', 1001, 1000, 65535, '输出内容：Hello, World!', '无输入', '输出"Hello, World!"', '', 'Hello, World!', '注意空格和符号（中/英）', 'XiaoJiang', '2019-02-10', '1', 1),
('被3整除', 1002, 1000, 65535, '在数学领域中，3是一个很奇特的数字。<br/>\r\n现在，给出一个很大的数字，判断其能否被3整除。<br/>\r\n如果这个数字能被3整除，请输出“YES”，否则输出“NO”。', '第一行为一个正整数n，表示数据的组数。<br/>\r\n接下来的n行，每行有一个正整数。<br/>\r\n​0 < n < 100;<br/>', 'YES 或 NO', '1\r\n3', 'YES', '数字的位数小于100位。<br/>\r\n输出时请注意大小写，不要输出引号！\r\n', '', '2019-02-11', '1', 1),
('分糖果', 1003, 1000, 65535, '万圣节终于到了，WYM在这一天收到了好多到多的糖，但是他自己一个人根本吃不完。他就想把这些糖分给他的朋友。他每次可分给别人任意块的糖果，但是他的朋友都很任性，每个人都不想得到跟上一个人一样数量的糖果。那么现在最多能分给多少人呢？', '一个正整数n (1  ≤  n  ≤ 10<sup>9</sup>) 表示糖果的数量。', '输出一个整数，表示分到糖果的人数。', '1', '1', '对于样例的解释：\r\n一块糖，一个人。（这不废话么！）', '', '2019-02-11', '1&2&3&4&5', 1),
('倒置域名', 1004, 1000, 65535, '域名通常由多个个片段以点隔开构成, 比如<br />\r\nwww.youtube.com<br />\r\ntieba.baidu.com<br />\r\nwww.google.com.hk<br />\r\nacm.hust.edu.cn<br />\r\nsegmentfault.com<br />\r\n请你写个程序将域名个各个段倒置, 上述域名通过你的程序后应该输出:<br />\r\ncom.youtube.www<br />\r\ncom.baidu.tieba<br />\r\nhk.com.google.www<br />\r\ncn.edu.hust.acm<br />\r\ncom.segmentfault<br />', '输入一个字符串域名, 不含空格,长度小于100', '输出倒置后的域名', 'acm.hust.edu.cn', 'cn.edu.hust.acm', '', 'xanarry', '2019-02-11', '1&2&3&4&5&6&7&8&9&10&11', 1),
('香蕉', 1005, 1000, 65535, '为了给唐僧找吃的，猴子来到了一片竹林。他看这里的竹子长得如此茂密，心想，这的竹子长得这么好，竹林里一定有很多半生不熟带梅花点的香蕉？？？<br />于是他来到竹林里面砍香蕉！<br />\r\n猴子费了好大劲采了a根香蕉堆成一堆（这不是拿汗毛变得吧？），这堆香蕉离唐僧b米,猴子打算把香蕉带回去给唐僧吃。<br />\r\n已知猴子每次最多能背c根，但是，众所周知，猴子嘴馋，如果身上有香蕉，每走一米要吃一根香蕉。那么聪明的你，知道猴子最多能背多少根香蕉给唐僧么？<br />\r\nP.S.：<br />\r\n他可以随时把香蕉扔到地上。也可以往回走。<br />\r\n猴子要么不走，要么走1米。<br />', '输入一行数字，为3个正整数a，b，c。<br />\r\n其中：a为香蕉总数，b为猴子到唐僧的直线距离，c为猴子每次携带香蕉的上限。<br />\r\n1 <= a，b，c<= 100，000<br />', '输出一个整数。为猴子能给唐僧带回去多少香蕉。', '100 50 50', '25', '对于样例的解释：<br />\r\n100根香蕉距离唐僧50米，猴子一次最多带50根。<br />\r\n第一次，猴子从50米处带50根香蕉到25米处，并放下（走了25米，消耗了25根香蕉）。此时：25米处有25根，50米处有50根。<br />\r\n第二次，猴子再从50米处带50根香蕉，到25米处。此时，25米处有50根香蕉。<br />\r\n第三次，猴子带所有香蕉回去，就剩下25根了。<br />', '硕硕', '2019-02-11', '1&2&3&4&5&6&7&8&9&10', 1),
('Web浏览', 1006, 1000, 65535, '实现浏览器的页面前后访问机制。有四种命令：<br/>\r\n1、BACK；<br/>\r\n2、FORWARD；<br/>\r\n3、VISIT：访问新的页面；<br/>\r\n4、QUIT：退出浏览器。<br/>\r\n请参考实际的浏览器按钮的功能。<br/>\r\n假设浏览器打开时，显示的页面是：http://www.acm.org/<br/>', '一系列命令：以BACK、FORWARD、VISIT或QUIT开头。如果是VISIT，后面要跟URL，长度不超过70，且不含空格。最后总是以QUIT结尾。', '对于每一个命令（除了QUIT），输出浏览页面的URL，如果命令被忽略，输出：Ignored。', 'VISIT http://acm.ashland.edu/\r\nVISIT http://asm.baylor.edu/acmipc/\r\nBACK\r\nBACK\r\nBACK\r\nFORWARD\r\nVISIT http://www.ibm.com/\r\nBACK\r\nBACK\r\nFORWARD\r\nFORWARD\r\nFORWARD\r\nQUIT', 'http://acm.ashland.edu/\r\nhttp://asm.baylor.edu/acmipc/\r\nhttp://acm.ashland.edu/\r\nhttp://www.acm.org/\r\nIgnored\r\nhttp://acm.ashland.edu/\r\nhttp://www.ibm.com/\r\nhttp://acm.ashland.edu/\r\nhttp://www.acm.org/\r\nhttp://acm.ashland.edu/\r\nhttp://www.ibm.com/\r\nIgnored', '', '', '2019-02-12', '1&2&3&4&5&6&7', 1);

-- --------------------------------------------------------

--
-- 表的结构 `oj_status`
--

CREATE TABLE IF NOT EXISTS `oj_status` (
  `RunID` int(11) NOT NULL COMMENT '运行ID',
  `User` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '用户',
  `Problem` int(11) NOT NULL COMMENT '问题编号',
  `Status` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '状态',
  `UseTime` int(11) NOT NULL COMMENT '耗时',
  `UseMemory` int(11) NOT NULL,
  `Language` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '语言',
  `CodeLen` int(11) NOT NULL COMMENT '代码长度',
  `SubTime` datetime NOT NULL COMMENT '提交时间',
  `AllStatus` varchar(1000) COLLATE utf8_bin NOT NULL COMMENT '测试点状态',
  `Show` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `oj_status`
--

INSERT INTO `oj_status` (`RunID`, `User`, `Problem`, `Status`, `UseTime`, `UseMemory`, `Language`, `CodeLen`, `SubTime`, `AllStatus`, `Show`) VALUES
(1, '肖江', 1000, 'Accepted', 15, 5092, 'C++', 126, '2019-02-10 03:06:05', '1&4&0&5088&0x0|2&4&15&5084&0x0|3&4&0&5088&0x0|4&4&0&5088&0x0|5&4&0&5088&0x0|6&4&15&5084&0x0|7&4&0&5092&0x0|8&4&15&5084&0x0|9&4&0&5084&0x0', 1),
(2, '肖江', 1001, 'Accepted', 15, 4856, 'C++', 83, '2019-02-10 03:06:55', '1&4&15&4856&0x0', 1),
(7, '吴泽', 1001, 'Accepted', 0, 4860, 'gcc', 68, '2019-02-10 03:31:47', '1&4&0&4860&0x0', 1),
(3, '吴泽', 1000, 'Presentation Error', 15, 4888, 'C++', 121, '2019-02-10 03:17:13', '1&5&0&4884&0x0|2&5&0&4880&0x0|3&5&0&4884&0x0|4&5&0&4884&0x0|5&5&0&4880&0x0|6&5&0&4884&0x0|7&5&0&4888&0x0|8&5&0&4880&0x0|9&5&15&4884&0x0', 1),
(4, '吴泽', 1000, 'Accepted', 46, 4884, 'C++', 120, '2019-02-10 03:17:25', '1&4&15&4884&0x0|2&4&0&4884&0x0|3&4&0&4884&0x0|4&4&15&4884&0x0|5&4&0&4884&0x0|6&4&46&4884&0x0|7&4&0&4884&0x0|8&4&0&4884&0x0|9&4&0&4884&0x0', 1),
(5, '吴泽', 1001, 'Wrong Answer', 0, 4860, 'C++', 67, '2019-02-10 03:18:35', '1&8&0&4860&0x0', 1),
(6, '吴泽', 1001, 'Accepted', 0, 4856, 'C++', 68, '2019-02-10 03:19:20', '1&4&0&4856&0x0', 1),
(8, '肖江', 1001, 'Compile Error', -1, -1, 'C++', 0, '2019-02-10 14:44:54', ' ', 0),
(9, '肖江', 1001, 'Compile Error', -1, -1, 'C++', 3, '2019-02-10 14:54:42', ' ', 0),
(10, '肖江', 1001, 'Compile Error', -1, -1, 'C++', 3, '2019-02-10 14:54:44', ' ', 0),
(11, '肖江', 1001, 'Compile Error', -1, -1, 'C++', 3, '2019-02-10 14:54:49', ' ', 0),
(12, '肖江', 1001, 'Compile Error', -1, -1, 'C++', 3, '2019-02-10 14:54:50', ' ', 0),
(13, '肖江', 1001, 'Compile Error', -1, -1, 'C++', 3, '2019-02-10 14:54:51', ' ', 0),
(14, '肖江', 1001, 'Compile Error', -1, -1, 'C++', 3, '2019-02-10 14:54:52', ' ', 0),
(15, '肖江', 1001, 'Compile Error', 0, 5216, 'C++', 0, '2019-02-10 14:55:26', '1&8&0&5216&0x0', 0),
(16, '肖江', 1001, 'Compile Error', -1, -1, 'C++', 0, '2019-02-10 14:56:35', ' ', 0),
(17, '肖江', 1001, 'Compile Error', -1, -1, 'C++', 0, '2019-02-10 14:57:22', ' ', 0),
(18, '肖江', 1000, 'Accepted', 15, 5092, 'C++', 126, '2019-02-10 14:57:43', '1&4&0&5088&0x0|2&4&0&5084&0x0|3&4&0&5088&0x0|4&4&0&5092&0x0|5&4&0&5088&0x0|6&4&0&5088&0x0|7&4&15&5084&0x0|8&4&15&5084&0x0|9&4&0&5084&0x0', 1),
(19, '吴泽', 1001, 'Accepted', 15, 4860, 'C++', 68, '2019-02-10 15:01:35', '1&4&15&4860&0x0', 1),
(20, '肖江', 1001, 'Accepted', 0, 4860, 'C++', 68, '2019-02-10 15:16:33', '1&4&0&4860&0x0', 1),
(21, '肖江', 1001, 'Accepted', 15, 5188, 'gcc', 68, '2019-02-10 15:16:45', '1&4&15&5188&0x0', 1),
(22, '肖江', 1000, 'Accepted', 46, 4884, 'gcc', 120, '2019-02-10 15:17:34', '1&4&0&4884&0x0|2&4&0&4884&0x0|3&4&0&4884&0x0|4&4&0&4884&0x0|5&4&0&4884&0x0|6&4&0&4884&0x0|7&4&0&4884&0x0|8&4&46&4884&0x0|9&4&0&4884&0x0', 1),
(23, '肖江', 1001, 'Accepted', 0, 4860, 'g++', 68, '2019-02-10 19:18:09', '1&4&0&4860&0x0', 1),
(24, '吴泽', 1001, 'Memory Limit Exceeded', 1140, 383644, 'C++', 100, '2019-02-10 20:02:39', '1&7&1140&383644&0x103', 1),
(25, '吴泽', 1000, 'Memory Limit Exceeded', 1125, 435652, 'C++', 100, '2019-02-10 20:04:52', '1&7&1000&411436&0x103|2&7&1031&419888&0x103|3&7&1125&433696&0x103|4&7&1093&419404&0x103|5&7&1093&426792&0x103|6&7&1125&435012&0x103|7&7&1031&432312&0x103|8&7&1000&435652&0x103|9&7&1125&425192&0x103', 1),
(26, '肖江', 1000, 'Accepted', 15, 4884, 'C++', 120, '2019-02-10 20:11:16', '1&4&15&4884&0x0|2&4&0&4884&0x0|3&4&0&4884&0x0|4&4&0&4884&0x0|5&4&0&4884&0x0|6&4&0&4884&0x0|7&4&15&4884&0x0|8&4&15&4884&0x0|9&4&0&4884&0x0', 1),
(27, '肖江', 1000, 'Accepted', 31, 5088, 'C++', 126, '2019-02-10 20:11:35', '1&4&0&5088&0x0|2&4&0&5076&0x0|3&4&0&5088&0x0|4&4&15&5088&0x0|5&4&0&5088&0x0|6&4&31&5084&0x0|7&4&0&5084&0x0|8&4&0&5088&0x0|9&4&0&5084&0x0', 1),
(28, '肖江', 1000, 'Accepted', 15, 5088, 'g++', 126, '2019-02-10 20:13:32', '1&4&0&5088&0x0|2&4&0&5084&0x0|3&4&0&5088&0x0|4&4&0&5088&0x0|5&4&15&5088&0x0|6&4&15&5084&0x0|7&4&0&5084&0x0|8&4&15&5084&0x0|9&4&0&5084&0x0', 1),
(29, '肖江', 1000, 'Accepted', 0, 5096, 'g++', 149, '2019-02-10 20:13:57', '1&4&0&5092&0x0|2&4&0&5088&0x0|3&4&0&5092&0x0|4&4&0&5096&0x0|5&4&0&5092&0x0|6&4&0&5088&0x0|7&4&0&5088&0x0|8&4&0&5088&0x0|9&4&0&5088&0x0', 1),
(30, '肖江', 1000, 'Accepted', 15, 5876, 'g++', 226, '2019-02-10 20:14:46', '1&4&0&5876&0x0|2&4&0&5868&0x0|3&4&0&5872&0x0|4&4&0&5872&0x0|5&4&0&5876&0x0|6&4&0&5868&0x0|7&4&0&5868&0x0|8&4&15&5868&0x0|9&4&0&5868&0x0', 1),
(31, '肖江', 1000, 'Accepted', 15, 8228, 'C++', 356, '2019-02-10 20:15:19', '1&4&0&8224&0x0|2&4&15&8224&0x0|3&4&0&8228&0x0|4&4&0&8224&0x0|5&4&0&8228&0x0|6&4&0&8220&0x0|7&4&15&8224&0x0|8&4&0&8220&0x0|9&4&15&8224&0x0', 1),
(32, '肖江', 1000, 'System Error', -1, -1, 'Python2.7', 120, '2019-02-10 22:18:07', ' ', 0),
(33, '肖江', 1000, 'Accepted', 15, 4888, 'gcc', 120, '2019-02-10 22:18:32', '1&4&15&4884&0x0|2&4&0&4888&0x0|3&4&0&4880&0x0|4&4&0&4884&0x0|5&4&0&4884&0x0|6&4&0&4884&0x0|7&4&0&4884&0x0|8&4&0&4884&0x0|9&4&0&4884&0x0', 1),
(34, '吴泽', 1000, 'Compile Error', -1, -1, 'gcc', 135, '2019-02-11 00:01:33', ' ', 1),
(35, '吴泽', 1000, 'Wrong Answer', 0, 5092, 'C++', 133, '2019-02-11 00:01:50', '1&8&0&5092&0x0|2&8&0&5084&0x0|3&8&0&5088&0x0|4&8&0&5088&0x0|5&8&0&5088&0x0|6&8&0&5084&0x0|7&8&0&5084&0x0|8&8&0&5084&0x0|9&8&0&5088&0x0', 1),
(36, '吴泽', 1000, 'Output Limit Exceeded', 15, 5096, 'C++', 139, '2019-02-11 00:02:13', '1&10&15&5088&0x0|2&10&15&5092&0x0|3&10&0&5088&0x0|4&10&0&5096&0x0|5&10&0&5088&0x0|6&10&0&5084&0x0|7&10&0&5084&0x0|8&10&0&5084&0x0|9&10&0&5084&0x0', 1),
(37, '吴泽', 1000, 'Output Limit Exceeded', 15, 5088, 'C++', 137, '2019-02-11 00:02:41', '1&10&0&5088&0x0|2&10&15&5084&0x0|3&10&15&5088&0x0|4&10&0&5088&0x0|5&10&0&5088&0x0|6&10&0&5088&0x0|7&10&0&5084&0x0|8&10&0&5084&0x0|9&10&0&5084&0x0', 1),
(38, '吴泽', 1000, 'Wrong Answer', 15, 5088, 'C++', 131, '2019-02-11 00:03:10', '1&8&0&5088&0x0|2&8&0&5084&0x0|3&8&0&5088&0x0|4&8&15&5088&0x0|5&8&0&5088&0x0|6&8&0&5084&0x0|7&8&0&5084&0x0|8&8&15&5084&0x0|9&8&0&5084&0x0', 1),
(39, '吴泽', 1000, 'Wrong Answer', 15, 4896, 'C++', 126, '2019-02-11 00:04:21', '1&4&0&4884&0x0|2&8&0&4896&0x0|3&8&0&4884&0x0|4&8&0&4884&0x0|5&8&15&4884&0x0|6&8&0&4884&0x0|7&8&0&4888&0x0|8&8&0&4884&0x0|9&8&0&4884&0x0', 1),
(40, '吴泽', 1001, 'Compile Error', -1, -1, 'C++', 0, '2019-02-11 00:19:03', ' ', 1),
(41, '肖江', 1002, 'Accepted', 0, 4880, 'C++', 376, '2019-02-11 00:55:08', '1&4&0&4880&0x0', 1),
(42, '肖江', 1002, 'Accepted', 0, 4880, 'C++', 376, '2019-02-11 00:58:36', '1&4&0&4880&0x0', 1),
(43, '肖江', 1003, 'Accepted', 15, 4892, 'C++', 430, '2019-02-11 01:20:48', '1&4&0&4880&0x0|2&4&0&4880&0x0|3&4&15&4880&0x0|4&4&0&4880&0x0|5&4&0&4892&0x0', 1),
(44, '肖江', 1004, 'Accepted', 31, 5068, 'C++', 338, '2019-02-11 01:39:03', '1&4&0&5064&0x0|2&4&0&5064&0x0|3&4&0&5068&0x0|4&4&15&5064&0x0|5&4&0&5064&0x0|6&4&0&5064&0x0|7&4&0&5064&0x0|8&4&0&5064&0x0|9&4&31&5064&0x0|10&4&0&5064&0x0|11&4&0&5056&0x0', 1),
(45, '肖江', 1005, 'Accepted', 62, 5132, 'C++', 418, '2019-02-11 01:56:12', '1&4&15&5128&0x0|2&4&0&5132&0x0|3&4&0&5132&0x0|4&4&0&5128&0x0|5&4&15&5128&0x0|6&4&15&5128&0x0|7&4&0&5128&0x0|8&4&0&5128&0x0|9&4&62&5128&0x0|10&4&0&5132&0x0', 1),
(46, '肖江', 1003, 'Accepted', 15, 5084, 'C++', 169, '2019-02-11 02:14:59', '1&4&0&5084&0x0|2&4&0&5084&0x0|3&4&0&5084&0x0|4&4&15&5084&0x0|5&4&0&5084&0x0', 1),
(47, '肖江', 1000, 'Accepted', 15, 5076, 'C++', 1198, '2019-02-11 02:16:29', '1&4&0&5076&0x0|2&4&0&5072&0x0|3&4&0&5076&0x0|4&4&0&5072&0x0|5&4&0&5076&0x0|6&4&0&5072&0x0|7&4&15&5072&0x0|8&4&0&5076&0x0|9&4&0&5076&0x0', 1),
(48, '肖江', 1000, 'Accepted', 15, 5144, 'C++', 2436, '2019-02-11 02:16:59', '1&4&15&5140&0x0|2&4&0&5144&0x0|3&4&0&5140&0x0|4&4&0&5140&0x0|5&4&0&5140&0x0|6&4&0&5144&0x0|7&4&0&5140&0x0|8&4&15&5140&0x0|9&4&0&5140&0x0', 1),
(50, '肖江', 1005, 'Accepted', 15, 5132, 'C++', 418, '2019-02-11 22:42:01', '1&4&15&5128&0x0|2&4&0&5128&0x0|3&4&15&5128&0x0|4&4&0&5128&0x0|5&4&0&5128&0x0|6&4&0&5128&0x0|7&4&0&5132&0x0|8&4&0&5132&0x0|9&4&0&5132&0x0|10&4&0&5128&0x0', 1),
(51, '肖江', 1004, 'Accepted', 46, 5072, 'C++', 340, '2019-02-11 22:43:32', '1&4&15&5064&0x0|2&4&46&5068&0x0|3&4&0&5064&0x0|4&4&15&5064&0x0|5&4&0&5064&0x0|6&4&0&5064&0x0|7&4&0&5064&0x0|8&4&15&5068&0x0|9&4&0&5064&0x0|10&4&15&5072&0x0|11&4&0&5060&0x0', 1),
(52, '肖江', 1004, 'Accepted', 15, 5072, 'C++', 338, '2019-02-12 01:06:48', '1&4&0&5068&0x0|2&4&0&5064&0x0|3&4&0&5064&0x0|4&4&15&5068&0x0|5&4&15&5064&0x0|6&4&15&5068&0x0|7&4&0&5072&0x0|8&4&0&5068&0x0|9&4&0&5064&0x0|10&4&0&5068&0x0|11&4&0&5056&0x0', 1),
(53, '肖江', 1006, 'Accepted', 640, 10936, 'C++', 1170, '2019-02-12 23:46:37', '1&4&0&5084&0x0|2&4&0&5084&0x0|3&4&0&5096&0x0|4&4&0&5116&0x0|5&4&0&5184&0x0|6&4&640&10876&0x0|7&4&593&10936&0x0', 1),
(54, '肖江', 1006, 'Wrong Answer', 609, 11060, 'C++', 718, '2019-02-13 00:29:36', '1&4&0&7408&0x0|2&4&15&7416&0x0|3&8&0&7424&0x0|4&8&0&7432&0x0|5&8&15&7456&0x0|6&8&515&11060&0x0|7&8&609&11016&0x0', 0),
(55, '肖江', 1000, 'Accepted', 15, 4884, 'gcc', 118, '2019-02-13 01:38:18', '1&4&0&4884&0x0|2&4&0&4884&0x0|3&4&0&4884&0x0|4&4&0&4884&0x0|5&4&0&4884&0x0|6&4&0&4884&0x0|7&4&0&4884&0x0|8&4&0&4884&0x0|9&4&15&4884&0x0', 1);

-- --------------------------------------------------------

--
-- 表的结构 `oj_user`
--

CREATE TABLE IF NOT EXISTS `oj_user` (
  `name` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '用户姓名',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `password` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '用户密码',
  `jurisdicton` int(11) NOT NULL COMMENT '权限',
  `signature` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '签名',
  `email` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '邮箱',
  `regtime` date NOT NULL COMMENT '注册时间',
  `logtime` date NOT NULL COMMENT '最后登陆的时间',
  `fight` int(11) NOT NULL COMMENT '战斗力',
  `skin` varchar(11) COLLATE utf8_bin NOT NULL COMMENT 'OJ皮肤'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `oj_user`
--

INSERT INTO `oj_user` (`name`, `uid`, `password`, `jurisdicton`, `signature`, `email`, `regtime`, `logtime`, `fight`, `skin`) VALUES
('肖江', 1, 'ieIAjVBw02', 2, '我不管，我最帅，我是你的小可爱               ', '751255159@qq.com', '2019-01-01', '2019-02-12', 3200, 'Slate'),
('吴泽', 2, 'wuze', 0, '嘤 嘤 嘤', '', '2019-02-01', '2019-02-13', 2000, 'spacelab');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
