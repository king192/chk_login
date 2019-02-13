<?php
namespace king192\chk_login\data;

abstract class data {
	abstract function getLastLoginTimeByUsername();

	abstract function getLoginRate();

	abstract function insertLoginRecord();
}