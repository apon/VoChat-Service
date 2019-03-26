VoChat-Service
=================

这是一个简单的用PHP基于[GatewayWorker](https://github.com/walkor/GatewayWorker)写的IM服务。

对应的Android客户端：[VoChat-Android](https://github.com/apon/VoChat-Android)

##### 相关文档：

-------

[GatewayWorker手册](http://doc2.workerman.net/)

[使用MySQL](http://doc2.workerman.net/mysql.html)

VoChat.sql

VoChat-Api.md

##### 用到的组件：

-------

PHP参数校验组件[php-validator](https://github.com/yunhack/php-validator)

##### 依赖的扩展：

-------

Workerman/MySQL类依赖[pdo](http://php.net/manual/zh/book.pdo.php)和[pdo_mysql](http://php.net/manual/zh/ref.pdo-mysql.php)两个扩展，如果没有pdo 或者 pdo_mysql，请自行安装。[（安装方法）](http://doc.workerman.net/components/workerman-mysql.html)

另php-validator会用到mbstring。

检测有没有mbstring：


```
php -m | grep mbstring
```

如果没有请自行安装：


```
yum install php-mbstring
```

##### 启动服务：

-------
启动服务前先在[Applications/VoChat/Events.php]文件中配置好数据库信息。

##### 启动

以debug（调试）方式启动

php start.php start

以daemon（守护进程）方式启动

php start.php start -d

[Workerman启动与停止](http://doc.workerman.net/install/start-and-stop.html)





