<?php
/**
 * Created by PhpStorm.
 * User: yaopeng
 * Date: 2019-03-19
 * Time: 18:20
 */
namespace VoChat\Model;

require_once __DIR__.'/ActionType.php';
require_once dirname(__DIR__).'/php-validator/ValidatorHelper.php';

use \GatewayWorker\Lib\Gateway;
use Yunhack\PHPValidator\ValidatorHelper;
class ChatMsgController
{
    public function getAction($cmd){
        if(isset($this->actionMap[$cmd])){
            return $this->actionMap[$cmd];
        }
    }

    public $actionMap = array(
        ActionType::CMD_SEND_MSG => 'actionSendMsg'
    );

    public function actionSendMsg($client_id,$request,$resp){
        $userId = Gateway::getUidByClientId($client_id);
        ValidatorHelper::make($request, [
            'fromId' => 'present',
            'toId' => 'present',
            'peerType' => 'present',
            'content' => 'present',
            'created' => 'present'
        ]);

        if (ValidatorHelper::has_fails()) {//参数出错
            echo ValidatorHelper::error_msg();
            $resp['code'] = ActionType::CODE_PARAMETER_ERROR;
            $resp['msg'] = ValidatorHelper::error_msg();
            Gateway::sendToClient($client_id, json_encode($resp));
        } else {//参数正确
            $toId = $request['toId'];
            $peerType = $request['peerType'];
            if ($peerType==ActionType::PEER_TYPE_GROUP){
//                Gateway::sendToGroup($toId,$sendMsg);
            }else if($peerType==ActionType::PEER_TYPE_C2C){

                // 如果不在线就先存起来
                if(!Gateway::isUidOnline($userId)){
                    $result = ChatMsgDao::storeMessage($request);
                    echo "用户不在线存储消息：".$result;
                }else{// 在线就转发消息给对应的uid
                    $request['code']= ActionType::CODE_SUCCESS;
                    $request['msg']="发送成功";
                    $request['cmd'] = ActionType::CMD_REC_MSG;
                    Gateway::sendToUid($toId,json_encode($request));
                    echo "用户在线转发消息消息：";
                }



            }

            $sendResult['code']= ActionType::CODE_SUCCESS;
            $sendResult['msg']="发送成功";
            $resp = array_merge($resp,$sendResult);
            Gateway::sendToClient($client_id, json_encode($resp));
        }
    }
}