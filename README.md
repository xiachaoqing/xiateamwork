夏小石工作管理系统
=======================

### 简介
后台系统基于zentaoPHP框架开发。
#### 特点

* 代码简单：
框架的核心只有四个文件，分别为调度类 router.class.php，control类 control.class.php，model类 model.class.php和工具类 helper.class.php。代码的实现也比较简单，有能力的开发者可以很容易在框架基础上进行扩展，增加自己的功能。
* 性能良好：
zentaoPHP框架在实现过程中，十分重视性能。在保证功能的前提下面，尽可能的提升程序执行效率。
* 结构清晰：
使用ZenTaoPHP框架来开发应用，其目录结构简单清晰，维护起来非常的方便。
* 开发友好：
框架，首先是一个框，把你框在了里面。所以很多框架会有很多的约定，你要怎样，你要怎样。还有很多隐形的约定，比如你要在你的代码里面写很多的xxxx之类的东东。我觉得一个好的框架在实现功能的前提下，应当尽量兼顾开发人员之前的开发习惯，所以zentaoPHP框架在这方面花了大量的力气：
* 中性命名：框架实现时，没有出现什么zentao之类的命名，完全是 中性的命名：router, control, model, config, lang。
* 配置对象化：配置项可以通过对象的方式来引用，$config->db->user，要比$config['db']['user']简洁顺畅的多。
* 相对路径包含：所有的路径都可以用相对路径来进行包含，这样可以很清晰的知道目录结构和代码之间的关系。
* 扩展性优秀

### 安装要求
* PHP >= 5.4
* MySQL

### 使用的第三方
* CSS框架 ：YUI 3 beta 中的 CSS套件，包括basic.css, reset.css, font.css和grid.css。官方网站： http://developer.yahoo.com/yui/3/
* JS框架 ：JQUERY 1.3版本。官方网站： http://www.jquery.com
* JQUERY插件： alert chosen colorize flot jquerytools sparkline treetable  validation autocomplete colorbox      datepicker  reverseorder tablesorter treeview
* 编辑器： kindeditor
* MAIL类 ：phpmailer 5.1，官方网站： http://phpmailer.sourceforge.net
* HTTP类 ：snoopy 官方网站： http://snoopy.sourceforge.net/
* 报表框架 ：fushioncharts free 官方网站： http://www.fusioncharts.com/free/
* zip压缩： pclzip
* yaml类： spyc