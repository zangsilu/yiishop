木瓜商城项目说明
============================

## 简介
 - 木瓜商城是采用YII2框架开发的一款在线商城.

## 编码规范

1. 私用变量以_开头,例如`private $_xxx_yyy`
2. 局部变量以小驼峰起名,例如`$someVarible`
3. 其余情况严格遵守[PSR2](http://www.php-fig.org/psr/psr-2/)规范

### 索引
  
  - 所有的id updated_at created_at 都应加上索引
  - 其它字段根据业务逻辑添加
  - 在测试的时候开启慢查询日志,进而分析索引问题
  
  
## 消息队列

### 消息体格式

```json
{
   "type":1,
   "body":{
   
   }
}
```

## 作者博客
   *    [https://blog.pl39.com](https:blog.pl39.com) 
   *    或
   *    [http://blog2.pl39.com](http:blog2.pl39.com) 
