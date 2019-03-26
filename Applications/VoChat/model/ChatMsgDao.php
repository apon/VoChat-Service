<?php
/**
 * Created by PhpStorm.
 * User: yaopeng
 * Date: 2019-03-19
 * Time: 18:19
 */
namespace VoChat\Model;
require_once __DIR__.'/ActionType.php';
class ChatMsgDao
{
    /**
     * 存储消息
     * @param $message
     */
    public static function storeMessage($message){
        global $db;
        $db->insert('offlineMessage')->cols(array(
            'id'=>$message['id'],
            'fromId'=>$message['fromId'],
            'fromName'=>$message['fromName'],
            'toId'=>$message['toId'],
            'toName'=>$message['toName'],
            'created'=>$message['created'],
            'peerType'=>$message['peerType'],
            'content'=>$message['content']
        ))->query();
    }

    /**
     * 删除已发送的消息
     * @param $message
     */
    public static function removeMessage($message){
        global $db;
        $db->delete('offlineMessage')->where("id={$message['id']} and fromId={$message['fromId']}")->query();
    }

    /**
     * 获取指定用户的离线消息
     * @param $ownerId
     * @return mixed
     */
    public static function getOfflineMessage($ownerId){
        global $db;
        $listMsg = $db->select('*')->from('offlineMessage')->where("toId=$ownerId")->query();
        return $listMsg;
    }
}