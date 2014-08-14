zookeeper
=========

使用zookeeper进行配置集中管理

我司更换了大量高配服务器后，随之带来的问题就是服务器的上架下架业务迁移。由于历史原因，我司的项目还是比较乱的，每次迁移都得又运维和研发一起来评估迁移的方案。但由于项目文档较少，还有项目开发人员不规范，带来了很多问题，造成迁移工作量巨大。
基于以上问题，我想到了配置的集中管理概念，选型也采用了比较通用的zookeeper服务。http://zookeeper.apache.org/

zookeeper有很多高级特性  http://www.ibm.com/developerworks/cn/opensource/os-cn-zookeeper/
    配置管理
    集群管理
    共享锁
    同步锁
    队列

而其中的配置集中管理功能非常适合我们的业务。

集中管理分为两个部分：
    1、运维管理节点数据
    2、研发申请并使用节点数据
其中涉及命令规范的问题，我使用了  /主机/站点/应用名字/服务名字/服务具体参数  这样的命名规范

具体的demo代码为

● 根据站点应用创建数据节点并写入数据
https://github.com/sunboyu/zookeeper/blob/master/admin.php

● 业务层读取数据
https://github.com/sunboyu/zookeeper/blob/master/client.php

● 路人甲可以读取任意一个站点的配置
https://github.com/sunboyu/zookeeper/blob/master/manage.php

● 增加了缓存，减少对zookeeper的压力，并且防止磬机
https://github.com/sunboyu/zookeeper/blob/master/config.php


php客户端无法解决的问题是：无法使用watch方法接受服务器端推送，这部分可以用java或者C来写，实现服务器端向各个客户端进行配置的推送更新。
本文档未解决的问题是：zookeeper的集群和可靠性


相关资源
zookeeper http://apache.dataguru.cn/zookeeper/stable/
jdk  http://download.oracle.com/otn-pub/java/jdk/7u67-b01/jdk-7u67-linux-x64.tar.gz?AuthParam=1408013534_2e6f99fc9308b998e2c7b3cd15c0ef07
phpext http://pecl.php.net/package/zookeeper




