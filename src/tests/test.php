<?php

namespace king192\chk_login\tests;

use king192\chk_login\data\db\dbManager;

class test {
    public function __construct()
    {
        echo 'hello';
    }

    public function getData() {
        $res = dbManager::getMysql([
            'dbtype' => 'mysql',
            'host' => '127.0.0.1',
            'dbname' => 'test',
            'port' => '3306',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'pconnect' => true,])
            ->queryRow('select * from web_admin_login_history where id = 1');
        var_export($res);
    }
}
