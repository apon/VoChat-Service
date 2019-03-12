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
        ActionType::USER_LOGIN => 'actionLogin',
        ActionType::USER_REGISTER => 'actionRegister',
        ActionType::USER_BING => 'actionBind'
    );

    /**
     * 登录
     * @param $client_id
     * @param $request
     */
    public function actionLogin($client_id,$request){
        $resp['id'] = $request['id'];
        $resp['cmd'] = $request['cmd'];
        ValidatorHelper::make($request, [
            'phone' => 'present|mobile',
            'password' => 'present'
        ]);

        if (ValidatorHelper::has_fails()) {//参数出错
            echo ValidatorHelper::error_msg();
            $resp['code'] = 200;
            $resp['msg'] = ValidatorHelper::error_msg();
            Gateway::sendToClient($client_id, json_encode($resp));
        } else {//参数正确
            $phone = $request['phone'];
            $pass = $request['password'];

            $loginResp = UserDao::login($phone,$pass);

            $resp = array_merge($resp,$loginResp);

            Gateway::sendToClient($client_id, json_encode($resp));
        }

    }

    /**
     * 注册
     * @param $client_id
     * @param $request
     */
    public function actionRegister($client_id,$request){
        $resp['id'] = $request['id'];
        $resp['cmd'] = $request['cmd'];
        ValidatorHelper::make($request, [
            'phone' => 'present|mobile',
            'password' => 'present'
        ]);

        if (ValidatorHelper::has_fails()) {//参数出错
            echo ValidatorHelper::error_msg();
            $resp['code'] = 200;
            $resp['msg'] = ValidatorHelper::error_msg();
            Gateway::sendToClient($client_id, json_encode($resp));
        } else {//参数正确
            $phone = $request['phone'];
            $pass = $request['password'];

            $registerResp = UserDao::register($phone,$pass);

            $resp = array_merge($resp,$registerResp);

            Gateway::sendToClient($client_id, json_encode($resp));
        }
    }

    /**
     * 绑定
     * @param $client_id
     * @param $request
     */
    public function actionBind($client_id,$request){

        $resp['id'] = $request['id'];
        $resp['cmd'] = $request['cmd'];
        ValidatorHelper::make($request, [
            'userid' => 'present'
        ]);

        if (ValidatorHelper::has_fails()) {//参数出错
            echo ValidatorHelper::error_msg();
            $resp['code'] = 200;
            $resp['msg'] = ValidatorHelper::error_msg();
            Gateway::sendToClient($client_id, json_encode($resp));
        } else {//参数正确
            $userId = $request['userid'];
            Gateway::bindUid($client_id,$userId);
            $resp['code'] = 0;
            $resp['msg'] = '绑定成功！';
            Gateway::sendToClient($client_id, json_encode($resp));
        }

    }

    public function hello($client_id,$action){
        echo $client_id.$action;
//        Gateway::sendToClient($client_id, json_encode('hello'));
    }

}