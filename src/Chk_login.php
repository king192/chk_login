<?php
namespace king192\chk_login;

use king192\chk_login\data\history;

class Chk_login {
	const SUCCESS_CODE = 1;
	const ERROR_CODE = 0;
    const LOGIN_STATUS = [
        'SUCCESS' => 1,
        'FAIL' => 0,
    ];
    const LOGIN_VERIFY = [
        'YES' => 1,
        'NO' => 0,
    ];
    const TRY_TIME = 300;

    protected $data = [
    	'table' => 'web_admin_login_history',

    ];

    protected $dataFactory = null;

	public static function test() {
		echo 'hi';
	}
	public function __construct($options = []) {
		if (!is_array($options)) {
			throw new \Exception("param need array");
			
		}
		$this->data = array_merge($this->data, $options);
	}


    public function limitLogin($username, $limit = 5) {
        $loginTime = $this->getFailLoginRate($username)['data'];
        if ($loginTime > $limit) {
        	$sql = 'select createTime from ' . $this->data['table'] . ' '
            $res = M()->table(MysqlConfig::Table_web_admin_login_history)->where(['username' => $username, 'loginVerify' => self::LOGIN_VERIFY['YES']])->order('createTime desc')->getField('createTime');
//            var_export((time() - (int)$res));
            $time = (self::TRY_TIME - (time() - (int)$res));
            $time = $this->friendTime($time);
            return ['code' => self::ERROR_CODE, 'msg' => '用户名或密码错误，该用户登录已锁定，' . ($time) . '后再尝试'];
        }
        return ['code' => self::SUCCESS_CODE, 'msg' => '用户名或密码错误，' . ($this->friendTime(self::TRY_TIME)) . '内还可以尝试' . ($limit - $loginTime) . '次'];
    }

    protected function getFailLoginRate($username) {
        $where = [
            'username' => $username,
            'loginStatus' => self::LOGIN_STATUS['FAIL'],
            'createTime' => ['egt', (time() - self::TRY_TIME)],
        ];
        $where = AgentModel::getInstance()->makeWhere($where);
        $res = M()->query('select count(1) as cnt from ' . MysqlConfig::Table_web_admin_login_history . $where . ' group by username');
        return ['code' => self::SUCCESS_CODE, 'msg' => 'ok', 'data' => (int)$res['0']['cnt']];
    }

    public function loginRecord($username, $status, $adminID = 0, $isVerify = self::LOGIN_VERIFY['YES']) {
        $res = M()->table(MysqlConfig::Table_web_admin_login_history)->add([
            'adminID' => $adminID,
            'username' => $username,
            'loginStatus' => $status,
            'loginVerify' => $isVerify,
            'createTime' => time(),
        ]);
        if (!$res) {

        }
    }

    protected function friendTime($time) {
        if ($time <= 60) {
            return $time . '秒';
        } elseif ($time <=60 * 60) {
            return floor($time/60) . '分' . ($time%60) . '秒';
        } elseif ($time <=60 * 60 * 24) {
            return floor($time/60/60) . '小时' . floor($time%(60*60)/60) . '分' . ($time%(60)) . '秒';
        } else {
            return floor($time/(60*60*24)) . '天' . floor($time%(60*60*24)/(60*60)) .'小时' . floor($time%(60*60)/60) . '分' . ($time%(60)) . '秒';
        }
    }

}