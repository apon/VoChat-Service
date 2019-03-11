<?php
/**
 * Created by PhpStorm.
 * UserDao: yaopeng
 * Date: 2019-03-11
 * Time: 16:29
 */
namespace VoChat\Model;
class UserDao
{
    public static function register($phone,$pass){
        global $db;
        $res = $db->select('*')->from('Users')->where("phone= $phone ")->row();
//        var_dump($res);

        if ($res){
            echo $phone.'已经注册!';
            $isOk['status'] = 1;
            $isOk['msg'] = '已经注册!';
        }else{
            $db->beginTrans();
            $db->insert('Users')->cols(array(
                'name'=>'vochat-1234',
                'phone'=>$phone,
                'avatar'=>''))->query();
            $userId = $db->select('id')->from('Users')->where("phone= $phone ")->row();
            $db->insert('LocalAuth')->cols(array(
                'user_id'=>$userId['id'],
                'name'=>'vochat-1234',
                'phone'=>$phone,
                'password'=>$pass))->query();
            $db->commitTrans();
            $isOk['status'] = 0;
            $isOk['msg'] = '注册成功!';
        }
        var_dump($isOk);
        return $isOk;
    }

    public static function login($phone,$pass){
        global $db;
        $res = $db->select('*')->from('Users')->where("phone= $phone ")->row();
        if (!$res){
            echo $phone.'未注册!';
        }else{
            $respass = $db->select('password')->from('LocalAuth')->where("phone= $phone ")->row();
            if ($pass==$respass['password']){
                echo $phone.'登录成功!';
            }else{
                echo $phone.'密码错误!';
            }
        }
    }

}