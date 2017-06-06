#为什么写了这个框架

#框架说明
YPHP框架引入了先进且实用的技术`composer` `命名空间`等

踩上了巨人的肩膀 `monglog` `medoo` `whoops`

#目录结构

project                 项目目录   
├─app                   应用目录   
│  ├─controllers        控制器目录   
│  ├─models             模型目录   
│  ├─views              视图目录   
├─common                cli模式命令目录   
├─config                配置文件目录   
├─core                  框架核心目录   
│  ├─function           公用函数库目录   
│  ├─yphp               YPHP基础类库目录   
│  |  ├─lib             YPHP驱动类库目录   
│  ├─init.php           框架初始化   
│  ├─yphp.php           YPHP框架核心类   
│  ├─yphp_cli.php       YPHP框架CLI模式核心类   
├─public                web访问目录   
│  ├─static             静态文件目录   
│  ├─index.php          入口文件   
│  ├─.htaccess          apache重定向规则   
├─runtime               运行时目录   
├─vendor                composer第三方类库目录   
├─composer.json         composer依赖文件   
   

#面向人群
PHP中级及以上开发者、BugLi的学员们以及各位不满足于仅仅了解“表象”的极客们。

#其他

框架作者：BugLi 
QQ:263273742
