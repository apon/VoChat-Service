<?php
/**
 * Created by PhpStorm.
 * UserDao: yaopeng
 * Date: 2019-03-11
 * Time: 16:29
 */
namespace VoChat\Model;
require_once __DIR__.'/ActionType.php';
class UserDao
{
    /**
     * 用户注册
     * @param $phone
     * @param $pass
     * @return mixed
     */
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
            $resp['code'] = ActionType::CODE_SUCCESS;
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

    /**
     * 用户登录
     * @param $phone
     * @param $pass
     * @return mixed
     */
    public static function login($phone,$pass){
        global $db;

        $isRegister = $db->select('*')->from('Users')->where("phone= $phone ")->row();
        if (!$isRegister){
            $resp['code'] = 300;
            $resp['msg'] = '未注册!';
        }else{
            $respass = $db->select('password')->from('LocalAuth')->where("phone= $phone ")->row();
            if ($pass==$respass['password']){
                $resp['code'] = ActionType::CODE_SUCCESS;
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
     * 重置密码
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
            $resp['code'] = ActionType::CODE_SUCCESS;
            $resp['msg'] = '成功重置密码!';
        }
        return $resp;
    }

    /**
     * 重置用户名
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
            $resp['code'] = ActionType::CODE_SUCCESS;
            $resp['msg'] = '成功重置名称!';
        }
        return $resp;
    }

    /**
     * 搜索用户
     * @param $phone
     * @return mixed
     */
    public static function searchUser($phone){
        global $db;
        $phone = $phone."%";
        $searchResult = $db->select('*')->from('Users')->where("phone like '$phone' ")->limit(30)->query();
        $resp['code'] = ActionType::CODE_SUCCESS;
        $resp['msg'] = '搜索完成!';
        $resp['data'] = $searchResult;
        return $resp;
    }

    /**
     * 添加联系人
     * @param $userId
     * @param $friendId
     * @return mixed
     */
    public static function addContact($userId,$friendId){
        global $db;
        $isUser = $db->select('*')->from('Users')->where("id= $friendId ")->row();
        if (!$isUser){//用户不重置
            $resp['code'] = 1;
            $resp['msg'] = '用户不存在!';
        }else{
            $isAdd = $db->select('*')->from('UserRelation')->where("userid= $userId AND friendid= $friendId ")->row();
            if (!$isAdd){//未以添加

                $db->insert('UserRelation')->cols(array(
                    'userid'=>$userId,
                    'friendid'=>$friendId
                ))->query();
            }
            $data = $db->select('Users.id,name,phone,avatar')->from('UserRelation')->innerJoin('Users','UserRelation.friendid = Users.id')
                ->where("userid = $userId")->query();
            $resp['code'] = ActionType::CODE_SUCCESS;
            $resp['msg'] = '成功添加!';
            $resp['data'] = $data;
        }

        return $resp;
    }

    /**
     * 获取联系人列表
     * @param $userId
     * @return mixed
     */
    public static function getContact($userId){
        global $db;
        $data = $db->select('Users.id,name,phone,avatar')->from('UserRelation')->innerJoin('Users','UserRelation.friendid = Users.id')
            ->where("userid = $userId")->query();

        $resp['code'] = ActionType::CODE_SUCCESS;
        $resp['msg'] = '成功获取联系人列表!';
        $resp['data'] = $data;
        return $resp;
    }

}