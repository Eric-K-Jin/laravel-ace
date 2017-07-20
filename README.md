# Laravel-ace
使用Laravel5.4整合ace Admin模板<br>
1、封装datatables插件<br>
2、完成权限管理模块<br>
3、加入layer弹出层插件<br>
配置使用<br>
1、新建.env文件，配置好APP_KEY，连接数据库<br>
2、执行php artisan migrate，将权限管理相关数据表导入数据库<br>
3、执行php artisan db:seed --class=DatabaseSeeder，将对应数据填充到数据表<br>
4、到hosts文件映射一个本地域名，在自己环境搭建虚拟主机映射到项目的public目录访问即可