<?php
/**
 * Created by PhpStorm.
 * UserDao: yaopeng
 * Date: 2019-03-11
 * Time: 21:26
 */
namespace VoChat\Model;

require_once __DIR__.'/ActionType.php';
require_once dirname(__DIR__).'/php-validator/ValidatorHelper.php';

use \GatewayWorker\Lib\Gateway;
use Yunhack\PHPValidator\ValidatorHelper;
class UserController
{


    public function getAction($cmd){
        if(isset($this->actionMap[$cmd])){
            return $this->actionMap[$cmd];
        }
    }

    public $actionMap = array(
        ActionType::CMD_LOGIN => 'actionLogin',
        ActionType::CMD_REGISTER => 'actionRegister',
        ActionType::CMD_BIND => 'actionBind',
        ActionType::CMD_RESET_PASSWORD => 'actionResetPassword',
        ActionType::CMD_RESET_NAME => 'actionResetName',
        ActionType::CMD_SEARCH_USER => 'actionSearchUser',
        ActionType::CMD_ADD_CONTACT => 'actionAddContact',
        ActionType::CMD_GET_CONTACT => 'actionGetContact',
        ActionType::CMD_UNBIND => 'actionUnBind'
    );

    /**
     * 登录
     * @param $client_id
     * @param $request
     * @param $resp
     */
    public function actionLogin($client_id,$request,$resp){

        ValidatorHelper::make($request, [
            'phone' => 'present|mobile',
            'password' => 'present'
        ]);

        if (ValidatorHelper::has_fails()) {//参数出错
//            echo ValidatorHelper::error_msg();
            $resp['code'] = ActionType::CODE_PARAMETER_ERROR;
            $resp['msg'] = ValidatorHelper::error_msg();
            Gateway::sendToClient($client_id, json_encode($resp));
        } else {//参数正确
            $phone = $request['phone'];
            $pass = $request['password'];

            $loginResp = UserDao::login($phone,$pass);

            $resp = array_merge($resp,$loginResp);

            Gateway::sendToClient($client_id, json_encode($resp));

            //如果登录成功则绑定用户
            if($resp['code']==ActionType::CODE_SUCCESS){
                $data  = $resp['data'];
                Gateway::bindUid($client_id,$data['id']);
                //发送离线消息
                $this->sendOfflineMessage($client_id);
            }
        }

    }

    /**
     * 注册
     * @param $client_id
     * @param $request
     * @param $resp
     */
    public function actionRegister($client_id,$request,$resp){

        ValidatorHelper::make($request, [
            'phone' => 'present|mobile',
            'password' => 'present'
        ]);

        if (ValidatorHelper::has_fails()) {//参数出错
            echo ValidatorHelper::error_msg();
            $resp['code'] = ActionType::CODE_PARAMETER_ERROR;
            $resp['msg'] = ValidatorHelper::error_msg();
            Gateway::sendToClient($client_id, json_encode($resp));
        } else {//参数正确
            $phone = $request['phone'];
            $pass = $request['password'];

            $registerResp = UserDao::register($phone,$pass);

            $resp = array_merge($resp,$registerResp);

            Gateway::sendToClient($client_id, json_encode($resp));

            //如果注册成功则绑定用户
            if($resp['code']==ActionType::CODE_SUCCESS){
                $data  = $resp['data'];
                Gateway::bindUid($client_id,$data['id']);
                //发送离线消息
                $this->sendOfflineMessage($client_id);
            }
        }
    }

    /**
     * 绑定
     * @param $client_id
     * @param $request
     * @param $resp
     */
    public function actionBind($client_id,$request,$resp){


        ValidatorHelper::make($request, [
            'userid' => 'present'
        ]);

        if (ValidatorHelper::has_fails()) {//参数出错
            echo ValidatorHelper::error_msg();
            $resp['code'] = ActionType::CODE_PARAMETER_ERROR;
            $resp['msg'] = ValidatorHelper::error_msg();
            Gateway::sendToClient($client_id, json_encode($resp));
        } else {//参数正确
            $userId = $request['userid'];
            Gateway::bindUid($client_id,$userId);
            $resp['code'] = ActionType::CODE_SUCCESS;
            $resp['msg'] = '绑定成功！';
            Gateway::sendToClient($client_id, json_encode($resp));
            //发送离线消息
            $this->sendOfflineMessage($client_id);
        }

    }

    /**
     * 解绑
     * @param $client_id
     * @param $request
     * @param $resp
     */
    public function actionUnBind($client_id,$request,$resp){

        $userId = Gateway::getUidByClientId($client_id);
        Gateway::unbindUid($client_id,$userId);
        $resp['code'] = ActionType::CODE_SUCCESS;
        $resp['msg'] = '解绑成功！';
        Gateway::sendToClient($client_id, json_encode($resp));

    }

    /**
     * 重置密码
     * @param $client_id
     * @param $request
     * @param $resp
     */
    public function actionResetPassword($client_id,$request,$resp){

        $userId = Gateway::getUidByClientId($client_id);

        ValidatorHelper::make($request, [
            'password' => 'present'
        ]);

        if (ValidatorHelper::has_fails()) {//参数出错
            echo ValidatorHelper::error_msg();
            $resp['code'] = ActionType::CODE_PARAMETER_ERROR;
            $resp['msg'] = ValidatorHelper::error_msg();
            Gateway::sendToClient($client_id, json_encode($resp));
        }elseif ($userId==null){
            $resp['code'] = ActionType::CODE_NO_BIND;
            $resp['msg'] = '未登录！';
            Gateway::sendToClient($client_id, json_encode($resp));
        }else {//参数正确
            $password = $request['password'];
            $resetPass = UserDao::resetPassword($userId,$password);
            $resp = array_merge($resp,$resetPass);

            Gateway::sendToClient($client_id, json_encode($resp));
        }
    }

    /**
     * 重置用户名
     * @param $client_id
     * @param $request
     * @param $resp
     */
    public function actionResetName($client_id,$request,$resp){

        $userId = Gateway::getUidByClientId($client_id);

        ValidatorHelper::make($request, [
            'name' => 'present'
        ]);

        if (ValidatorHelper::has_fails()) {//参数出错
            echo ValidatorHelper::error_msg();
            $resp['code'] = ActionType::CODE_PARAMETER_ERROR;
            $resp['msg'] = ValidatorHelper::error_msg();
            Gateway::sendToClient($client_id, json_encode($resp));
        }elseif ($userId==null){
            $resp['code'] = ActionType::CODE_NO_BIND;
            $resp['msg'] = '未登录！';
            Gateway::sendToClient($client_id, json_encode($resp));
        }else {//参数正确
            $name = $request['name'];
            $resetName=UserDao::resetName($userId,$name);
            $resp = array_merge($resp,$resetName);

            Gateway::sendToClient($client_id, json_encode($resp));
        }
    }

    /**
     * 搜索用户
     * @param $client_id
     * @param $request
     * @param $resp
     */
    public function actionSearchUser($client_id,$request,$resp){

        $phone = $request["phone"];
        $searchResult = UserDao::searchUser($phone);
        $resp = array_merge($resp,$searchResult);
        Gateway::sendToClient($client_id, json_encode($resp));
    }

    /**
     * 添加联系人
     * @param $client_id
     * @param $request
     * @param $resp
     */
    public function actionAddContact($client_id,$request,$resp){

        $userId = Gateway::getUidByClientId($client_id);

        ValidatorHelper::make($request, [
            'friendid' => 'present'
        ]);

        if (ValidatorHelper::has_fails()) {//参数出错
            echo ValidatorHelper::error_msg();
            $resp['code'] = ActionType::CODE_PARAMETER_ERROR;
            $resp['msg'] = ValidatorHelper::error_msg();
            Gateway::sendToClient($client_id, json_encode($resp));
        }elseif ($userId==null){
            $resp['code'] = ActionType::CODE_NO_BIND;
            $resp['msg'] = '未登录！';
            Gateway::sendToClient($client_id, json_encode($resp));
        }else {//参数正确
            $friendid = $request['friendid'];
            $data = UserDao::addContact($userId,$friendid);
            $resp = array_merge($resp,$data);

            Gateway::sendToClient($client_id, json_encode($resp));
        }
    }

    /**
     * 获取联系人列表
     * @param $client_id
     * @param $request
     * @param $resp
     */
    public function actionGetContact($client_id,$request,$resp){
        $userId = Gateway::getUidByClientId($client_id);
        if ($userId==null){
            $resp['code'] = ActionType::CODE_NO_BIND;
            $resp['msg'] = '未登录！';
            Gateway::sendToClient($client_id, json_encode($resp));
        }else {
            $data = UserDao::getContact($userId);
            $resp = array_merge($resp,$data);
            Gateway::sendToClient($client_id, json_encode($resp));
        }
    }

    public function hello($client_id,$action){
        echo $client_id.$action;
//        Gateway::sendToClient($client_id, json_encode('hello'));
    }

    /**
     * 用户绑定后，给用户发送离线消息
     * @param $client_id
     */
    private function sendOfflineMessage($client_id){
        $userId = Gateway::getUidByClientId($client_id);
        $listMsg = ChatMsgDao::getOfflineMessage($userId);
        echo "发送离线消息".$listMsg;
        if($listMsg){
            $arrlength=count($listMsg);

            for($x=0;$x<$arrlength;$x++)
            {
                $msg = $listMsg[$x];
                $msg['code']= ActionType::CODE_SUCCESS;
                $msg['msg']="发送成功";
                $msg['cmd'] = ActionType::CMD_REC_MSG;
                Gateway::sendToUid($userId,json_encode($msg));
                ChatMsgDao::removeMessage($msg);
            }
        }
    }

}