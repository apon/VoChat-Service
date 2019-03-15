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
            $user = $db->select('*')->from('Users')->where("phone= $phone ")->row();
            $db->insert('LocalAuth')->cols(array(
                'user_id'=>$user['id'],
                'phone'=>$phone,
                'password'=>$pass))->query();
            $db->commitTrans();
            $resp['code'] = 0;
            $resp['msg'] = '注册成功!';
            $resp['data'] = $user;
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

    /**
     * @param $userId
     * @param $pass
     * @return mixed
     */
    public static function resetPassword($userId,$pass){
        global $db;
        $row_count = $db->update('LocalAuth')->cols(array('password'=>$pass))->where("user_id=$userId")->query();
        if ($row_count==0){
            $resp['code'] = 1;
            $resp['msg'] = '设置失败或与密码相同!';
        }else{
            $resp['code'] = 0;
            $resp['msg'] = '成功重置密码!';
        }
        return $resp;
    }

    /**
     * @param $userId
     * @param $name
     * @return mixed
     */
    public static function resetName($userId,$name){
        global $db;
        $row_count = $db->update('Users')->cols(array('name'=>$name))->where("id=$userId")->query();
        if ($row_count==0){
            $resp['code'] = 1;
            $resp['msg'] = '设置失败或与原名相同!';
        }else{
            $resp['code'] = 0;
            $resp['msg'] = '成功重置名称!';
        }
        return $resp;
    }

    /**
     * @param $phone
     * @return mixed
     */
    public static function searchUser($phone){
        global $db;
        $phone = $phone."%";
        $searchResult = $db->select('*')->from('Users')->where("phone like '$phone' ")->limit(30)->query();
        $resp['code'] = 0;
        $resp['msg'] = '搜索完成!';
        $resp['data'] = $searchResult;
        return $resp;
    }

}