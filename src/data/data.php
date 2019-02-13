<?php
namespace king192\chk_login\data;

abstract class data {
	abstract function getLastLoginTimeByUsername($username);

	abstract function getLoginRate($username);

	abstract function insertLoginRecord($userID, $username, $status, $isVerify);
}