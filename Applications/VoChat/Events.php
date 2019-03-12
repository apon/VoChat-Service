<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);
require_once __DIR__.'/model/ActionType.php';
require_once __DIR__.'/model/UserController.php';
require_once __DIR__.'/mysql-master/src/Connection.php';
require_once __DIR__ . '/model/UserDao.php';
require_once __DIR__.'/php-validator/ValidatorHelper.php';


use \GatewayWorker\Lib\Gateway;
use \Vochat\Model\UserController;
use \VoChat\Model\UserDao;
use Yunhack\PHPValidator\ValidatorHelper;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    public static function onWorkerStart($worker){
        //初始化数据库
        global $db;
        $db = new \Workerman\MySQL\Connection('120.78.175.94', '3306', 'root', 'yaopeng', 'vochat');

//        $resp = UserDao::login("18978403465","123456");
//        echo json_encode($resp);
        //初始化控制器
        global $controllersArray;
        $userController = new UserController();
        $controllersArray = array(
            $userController
        );

//        $param = array(
//            'phone'=>'18978403462'
//        );
//        ValidatorHelper::make($param, [
//            'phone' => 'present|mobile',
//            'money' => 'present',
//            'time' => 'date_format:Y-m-d',
//        ]);
//
//        if (ValidatorHelper::has_fails()) {
//            echo ValidatorHelper::error_msg();
//        } else {
//            echo "参数正确！";
//        }

    }


    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param mixed $message 具体消息
     * @throws Exception
     */
   public static function onMessage($client_id, $message)
   {
       $request = json_decode($message,true);
       if (isset($request['cmd'])){
           $cmd = $request['cmd'];
           self::callHook($cmd,$client_id,$request);
       }else{
            $resp = array(
                'id'=>$request['id'],
                'code'=>'404',
                'msg'=>'缺少cmd参数或服务器无法处理该cmd'
            );
           Gateway::sendToClient($client_id,json_encode($resp));
       }

   }


    /**
     *
     * @param $cmd
     * @param $client_id
     * @param $request
     */
    private static function callHook($cmd,$client_id,$request) {
        global $controllersArray;
        $hasMethod = false;
        foreach ($controllersArray as $controller)
        {
            $action = $controller->getAction($cmd);
            echo $action;
            if (method_exists($controller, $action)){
                call_user_func_array(array($controller, $action), array($client_id,$request));
                $hasMethod = true;
                break;
            }
        }

        if (!$hasMethod){
            echo '无法处理CMD:'.$cmd;
        }
    }

}
