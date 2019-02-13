<?php

namespace king192\chk_login\data;
use king192\chk_login\data\data;

class history {
	protected $_instance = null;
	public function __construct($_instance) {
		if (!($_instance instanceof data)) {
			throw new \Exception("class need extends king192\chk_login\data\data");			
		}
		$this->_instance = $_instance;
	}
	public function getLastLoginTimeByUsername($username) {
		return $this->_instance->getLastLoginTimeByUsername($username);
	}

	public function getLoginRate($username) {
		return $this->_instance->getLoginRate($username);
	}

	public function insertLoginRecord($userID, $username, $status, $isVerify) {
		return $this->_instance->insertLoginRecord($userID, $username, $status, $isVerify);
	}
}