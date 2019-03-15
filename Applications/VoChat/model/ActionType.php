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
    //用户相关cmd
    const CMD_LOGIN   = 1000;//用户登录
    const CMD_REGISTER   = 1001;//用户注册
    const CMD_BING   = 1002;//用户绑定/每次成功连接到服务器时都用用户id跟当前连接绑定
    const CMD_RESET_PASSWORD = 1003;//修改密码
    const CMD_RESET_NAME = 1004;//修改用户名
    const CMD_SEARCH_USER = 1005;//搜索用户
}