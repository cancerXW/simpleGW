<?php
require_once __DIR__ . '/GatewayWorker/vendor/autoload.php';

use \GatewayWorker\Lib\Gateway;
use Workerman\MySQL\Connection;
use GatewayWorker\Lib\Db;

$db_config = require_once __DIR__ . '/GatewayWorker/config/db.php';

$act = $_GET['act'];
$client_id = $_GET['client_id'];

switch ($act) {
    case 'register':
        break;
    case 'login':
        break;
    case 'getInfo':
        $db = new Connection($db_config['DB_HOST'], $db_config['DB_PORT'], $db_config['DB_USER'], $db_config['DB_PWD'], $db_config['DB_NAME']);
        $data = $db->select('*')->from('test')->where('client_id= :client_id')->bindValues(array('client_id' => $client_id))->query();
        dump($data);
        break;
    case 'setInfo':
        Gateway::sendToClient($client_id, $_GET['ms']);
        break;
}

/**
 * 浏览器友好的变量输出
 * @param mixed $var 变量
 * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
 * @param string $label 标签 默认为空
 * @param boolean $strict 是否严谨 默认为true
 * @return void|string
 */
function dump($var, $echo = true, $label = null, $strict = true)
{
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    } else
        return $output;
}
//测试链接GitHub是否成功