基于 laravel + ace 的简易后台
20190321
使用方法：
进入项目根目录，
composer install,
导入跟目录下的 laravel_blog.sql 文件，
复制 .env.example 文件并改名为 .env，
使用命令 php artisan key:generate 获取密码，会自动保存到 .env，
设置 .env 文件中的相关配置(如数据库)，
php artisan serve 开启服务，
即可食用。
