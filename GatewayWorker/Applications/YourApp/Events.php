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


use \GatewayWorker\Lib\Gateway;

use \Workerman\MySQL\Connection;
use \GatewayWorker\Lib\Db;


/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     *
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {
        // 向当前连接客户端回传链接id
        Gateway::sendToClient($client_id, $client_id);
    }

    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param mixed $message 具体消息
     */
    public static function onMessage($client_id, $message)
    {
        // 向所有人发送 
//        Gateway::sendToAll("$client_id said $message\r\n");
        $db = Db::instance('simplegw');
//        $is_register = $db->select('*')->from('connect_info')->cols(array('equipment_id' => $message))->query();
        $type = substr($message, 25, 29);
        switch ($type) {
            case '0x00':
                break;
            case '0x01':
                break;
            case '0x02':
                break;
            case '0x03':
                break;
            case '0x04':
                break;
            case '0x05':
                break;
            case '0x06':
                break;
            case '0x07':
                break;
            case '0x08':
                break;

        }
//        $insert_id = $db->insert('test')->cols(array('title' => "测试数据: $message", 'client_id' => $client_id))->query();


    }

    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id)
    {
        // 向所有人发送
//        GateWay::sendToAll("$client_id logout\r\n");
        $_SESSION['client_id'] = null;
    }
}
