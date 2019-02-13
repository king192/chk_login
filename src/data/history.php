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
	public function getLastLoginTimeByUsername() {
		return $this->_instance->getLastLoginTimeByUsername();
	}

	public function getLoginRate() {
		return $this->_instance->getLoginRate();
	}

	public function insertLoginRecord() {
		return $this->_instance->insertLoginRecord();
	}
}