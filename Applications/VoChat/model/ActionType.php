<?php
/**
 * Created by PhpStorm.
 * UserDao: yaopeng
 * Date: 2019-03-10
 * Time: 03:47
 */
namespace VoChat\Model;
class ActionType
{
    const USER_LOGIN   = 1000;//用户登录
    const USER_REGISTER   = 1001;//用户注册
    const USER_BING   = 1002;//用户绑定/每次成功连接到服务器时都用用户id跟当前连接绑定

}