<?php

namespace king192\chk_login\tests;

use king192\chk_login\data\db\dbManager;

class test {
    protected $dbData = [
        'dbtype' => 'mysql',
        'host' => '127.0.0.1',
        'dbname' => 'test',
        'port' => '3306',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
        'pconnect' => true,];

    public function __construct()
    {
        echo 'hello';
    }

    public function getData() {
        $arrWhere = [
            'id' => 1,
        ];

        $where = dbManager::getMysql($this->dbData)->makePdoWhere($arrWhere);
        var_export($where);
        $res = dbManager::getMysql($this->dbData)
            ->queryRow('select * from web_admin_login_history ' . $where['strWhere'], $where['arrBindWhere']);
        var_export($res);
    }
}
