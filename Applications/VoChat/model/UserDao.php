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
        $isRegister = $db->select('*')->from('Users')->where("phone= $phone ")->row();

        if ($isRegister){
            echo $phone.'已经注册!';
            $resp['code'] = 1;
            $resp['msg'] = '已经注册!';
        }else{
            $userName = 'VOCHAT-'.self::getRandChar(4);
            $db->beginTrans();
            $db->insert('Users')->cols(array(
                'name'=>$userName,
                'phone'=>$phone,
                'avatar'=>''))->query();
            $userId = $db->select('id')->from('Users')->where("phone= $phone ")->row();
            $db->insert('LocalAuth')->cols(array(
                'user_id'=>$userId['id'],
                'phone'=>$phone,
                'password'=>$pass))->query();
            $db->commitTrans();
            $resp['code'] = 0;
            $resp['msg'] = '注册成功!';
        }
        return $resp;
    }

    /**
     * 生成随机字符串
     * @param $length
     * @return string|null
     */
    private static function getRandChar($length){
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $max = strlen($strPol)-1;

        for($i=0;$i<$length;$i++){
            $str.=$strPol[rand(0,$max)];
        }

        return $str;
    }


    public static function login($phone,$pass){
        global $db;

        $isRegister = $db->select('*')->from('Users')->where("phone= $phone ")->row();
        if (!$isRegister){
            $resp['code'] = 300;
            $resp['msg'] = '未注册!';
        }else{
            $respass = $db->select('password')->from('LocalAuth')->where("phone= $phone ")->row();
            if ($pass==$respass['password']){
                $resp['code'] = 0;
                $resp['msg'] = '登录成功!';
                $resp['data'] = $isRegister;
            }else{
                $resp['code'] = 300;
                $resp['msg'] = '密码错误!';
            }
        }

        return $resp;
    }

}