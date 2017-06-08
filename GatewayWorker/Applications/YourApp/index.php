<?php
/**
 *引入文件
 */

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/config/Db.php';

use \GatewayWorker\Lib\Gateway;
use \GatewayWorker\Lib\Db;

$act = $_GET['act'];
$client_id = $_GET['client_id'];
$db = Db::instance('simplegw');
switch ($act) {
    case 'bind':
        if (!isset($_GET['user_id']) && !isset($_GET['equipment_id'])) {
            $db->insert('connect_info')->cols(array('user_id' => $_GET['user_id'], 'equipment_id' => $_GET['equipment_id']))->query();
        }
    case 'getInfo':
        $data = $db->select('*')->from('test')->where('client_id= :client_id')->bindValues(array('client_id' => $client_id))->query();
        dump($data);
        break;
    case 'setInfo':
        Gateway::sendToClient($client_id, $_GET['ms']);
        break;
}

