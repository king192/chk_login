# chk_login
限制用户登录次数
```
<?php
ini_set('display_errors', 1);
require_once 'vendor/autoload.php';
use king192\chk_login\Chk_login;

if (isset($_POST) && !empty($_POST)) {
    $obj = new Chk_login([
        'table' => 'web_admin_login_history',
        'dataInstanceData' => [
            'class' => 'king192\chk_login\data\pdoExample',
            'dbtype' => 'mysql',
            'host' => '127.0.0.1',
            'dbname' => 'test',
            'port' => '3306',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'pconnect' => true,
        ],
    ]);
    $username = $_POST['username'];
    $password = $_POST['password'];
    $res = $obj->limitLogin($username);
    if ($res['code'] = Chk_login::ERROR_CODE) {
        $obj->loginRecord($username, Chk_login::LOGIN_STATUS['FAIL'], 0, self::LOGIN_VERIFY['NO']);
        exit(json_encode($res));
    }
    if ($username != 'user123') {
        $obj->loginRecord($username, Chk_login::LOGIN_STATUS['FAIL']);
        exit(json_encode($res));
    }
    if ($password != '123456') {
        $obj->loginRecord($username, Chk_login::LOGIN_STATUS['FAIL'], 1);
        exit(json_encode($res));
    }
    $obj->loginRecord($username, Chk_login::LOGIN_STATUS['FAIL'], 1);
    exit(json_encode(['code' => Chk_login::SUCCESS_CODE, 'msg' => 'ok']));
}
echo 'hh';
```
