<?php
/**
 * Created by PhpStorm.
 * UserDao: yaopeng
 * Date: 2019-03-11
 * Time: 21:26
 */
namespace VoChat\Model;

require_once __DIR__.'/ActionType.php';

use \GatewayWorker\Lib\Gateway;

class UserController
{


    public function getAction($cmd){
        if(isset($this->actionMap[$cmd])){
            return $this->actionMap[$cmd];
        }
    }

    public $actionMap = array(
        ActionType::USUER_LOGIN => 'actionLogin',
        ActionType::USER_REGISTER => 'actionRegister'
    );

    public function actionLogin($client_id,$request){

        $name = $request['name'];
        $pass = $request['pass'];
        $res['id'] = $request['id'];
        $res['cmd'] = $request['cmd'];
        if ($name=="yaopeng"&&$pass=="123456"){
            $res['status'] = 0;
            $res['msg'] = 'login success!';
        }else{
            $res['status'] = 1;
            $res['msg'] = 'login error';
        }

        Gateway::sendToClient($client_id, json_encode($res));
    }

    public function actionRegister($client_id,$request){

    }

    public function hello($client_id,$action){
        echo $client_id.$action;
//        Gateway::sendToClient($client_id, json_encode('hello'));
    }

}