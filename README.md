# DFS微信小程序后台管理系统


## 前言
DFS是一个奢侈品旅游零售商。自1960年于香港成立，其免税店网络已包括18个主要国际机场及14个市区T广场店铺，同时其附属及度假村据点亦遍布全球。

本仓为DFS微信小程序后台管理系统，为小程序前端提供数据支持和会话访问。后台所有代码均部署在业务服务器上，用户登录请求等与微信服务器交互的请求则由会话服务器提供支持。

[DFS微信小程序前端](https://github.com/huysh3/DFS)

## 后台简介
业务服务器为nginx，服务器语言为PHP，操作系统为CentOS7.2，数据库为MySQL。应用程序使用Code Igniter框架设计，

## 文件树结构
```
├─application
│  ├─business
│  ├─cache
│  ├─config
│  ├─controllers
│  │  ├─Admin
│  │  └─Home
│  ├─core
│  ├─helpers
│  ├─hooks
│  ├─language
│  ├─libraries
│  ├─logs
│  ├─models
│  ├─third_party
│  └─views
│      ├─Admin
│      └─errors
├─Public
│  ├─lib
│  └─statics
├─system
│  ├─core
│  ├─database
│  ├─fonts
│  ├─helpers
│  ├─language
│  └─libraries
└─vendor
    ├─bin
    │  └─php-sdk-7.1.3
    ├─composer
    └─qcloud

```
CI是一个做起前后分离来比较蛋疼的框架，

## 开发点滴
1. 由于是第一次使用CI框架，以往都是使用TP框架，在前后端分离方面完成的不是特别好。CI框架支持模板引擎，在初始化函数中使用`$this-> library -> parser`即可调用`$this-> parser -> parse ('xxx.html',$data)`方法。其中'xxx.html'为模板页面，$data是需要渲染的数组。

2. 为提高模型与控制器的解耦度，应当设置基类控制器和基类模型，将常用的CURD等操作写在基类里面。

3. 涉及到文件读写，一定要检查是否有读写权限。服务器默认文件root拥有所有权限，而其余管理员和游客都只有读的权限。需要使用$ chmod -R 777 文件名 赋予所有账户所有权限，才能顺利读写。

4. “Cannot use object of type stdClass as array in ... ”开发时遇到了这个问题。源代码如下：
```
// 正确：
$product_info[$key]=$value;
$product_info[$key]->RMB=($value->price)*$exchange_rate;
// 错误：
// $product_info[$key]=$value;
// $product_info[$key]['RMB']=($value->price)*$exchange_rate;
```
区别在于$product_info其实是一个对象，不能再下面引用任何数组，要用"->"的方式引用。至于为什么$value会是一个对象，原因在于下面：
```
public function get_all_product($map=''){
  if($map!='')
    {
      $data=$this -> db
        -> where($map)
        -> get('product');
    }
    else $data=$this-> db ->get('product');
    return $data->result();
}
```
CI框架下，result()得到的是一个数组对象。如果将result()换成result_array()就没问题了。


## 开发进度

#### 新增
- [ ] 商家端后台系统
  - [ ] 获取所有订单接口（待完成和已完成两类）
  - [ ] 订单已交付确认接口
  - [ ] 优惠券控制接口
- [ ] 我方后台系统
  - [ ] 修改库存
  - [ ] 限购数目
- [x] 前端
  - [x] 汇率处理
  - [x] 商品需返回品牌及库存字段
- [ ] 数据库
  - [x] 商品：添加库存字段
  - [x] 商品：添加品牌字段
  - [ ] 新增：优惠券表

#### 删除


#### 修改
- [x] 商家信息

## 名片

    <title> 奇点实验室 </title>
    <name> 樊家豪 </name>
    <job> 队长 </job>
    <location> 中山大学电子与信息工程学院 </location>
    <slogan> 每一点都很重要 </slogan>
