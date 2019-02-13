<?php
namespace king192\chk_login\data\db;

use king192\chk_login\data\db\dbHelper;
/**
 * dbHelper instance 管理类
 * Class DBManager
 */
class dbManager
{
    private static $_instance = array();

    private function __clone()
    {
    }

    /**
     * 获取一个MysqlHelper实例
     * @param $dbType
     * @param $dbConfig
     * @return mixed|dbHelper
     */
    private static function getInstance($dbConfig)
    {
        $dbType = md5(serialize($dbConfig));
        $instance = isset(self::$_instance[$dbType]) ? self::$_instance[$dbType] : null;
        if (!$instance instanceof dbHelper) {
            $dbtype = $dbConfig['dbtype'];
            $host = $dbConfig['host'];
            $dbname = $dbConfig['dbname'];
            $port = $dbConfig['port'];
            $username = $dbConfig['username'];
            $password = $dbConfig['password'];
            $charset = $dbConfig['charset'];
            $pconnect = $dbConfig['pconnect'];

            $instance = new dbHelper($dbtype, $host, $dbname, $port, $username, $password, $charset, $pconnect);
            self::$_instance[$dbType] = $instance;
        }
        //检查连接
        $instance->checkConnect();
        return $instance;
    }

    /**
     * 主要的数据库
     * @return mixed|dbHelper
     */
    public static function getMysql($options)
    {
        return self::getInstance($options);
    }

    /**
     * 关闭所有数据库连接
     */
    public static function closeAllDB()
    {
        foreach (self::$_instance as $key => &$instance) {
            if ($instance instanceof dbHelper) {
                $instance->close();
                $instance = NULL;
            }
        }
    }
}