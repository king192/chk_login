<?php

namespace king192\chk_login\data;

use king192\chk_login\data\data;
use king192\chk_login\data\db\dbManager;
use king192\chk_login\Chk_login;

class pdoExample extends data {
    protected $options = [];
    protected $table = null;
    public function __construct()
    {
    }

    public function setParam($options, $table)
    {
        $this->options = $options;
        $this->table = $table;
    }

    public function getLastLoginTimeByUsername($username) {
        $sql = 'select createTime from ' . $this->table . ' where username = ' . $username . ' and loginVerify = ' . Chk_login::LOGIN_VERIFY['YES'] . ' order by createTime desc limit 1';
        $res = dbManager::getMysql($this->options)->queryRow($sql);
        return $res;
	}

	public function getLoginRate($username) {
        $where = [
            'username' => $username,
            'loginStatus' => Chk_login::LOGIN_STATUS['FAIL'],
            'createTime' => ['egt', (time() - Chk_login::TRY_TIME)],
        ];
        $where = dbManager::getMysql($this->options)->makeWhere($where);
        $res = dbManager::getMysql($this->options)->queryRow('select count(1) as cnt from ' . $this->table . $where . ' group by username');
        return $res;
	}

	public function insertLoginRecord($userID, $username, $status, $isVerify) {
        $res = dbManager::getMysql($this->options)->insert($this->table, [
            'userID' => $userID,
            'username' => $username,
            'loginStatus' => $status,
            'loginVerify' => $isVerify,
            'createTime' => time(),
        ]);
        return $res;
	}

	
}