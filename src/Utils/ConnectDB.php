<?php

namespace Spider\Utils;


use Doctrine\DBAL\Configuration;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class ConnectDB
{

    private static $_singleton;
    private $_connection;
    private $entityManager;


    /**
     * ConnectDB constructor.
     */
    private function __construct()
    {

        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode);
        $connectionParams = array(
            'dbname' => 'mydb',
            'user' => 'root',
            'password' => '',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        );
        $this->_connection = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
        $this->entityManager = EntityManager::create($this->_connection, $config);
         register_shutdown_function(array(&$this, 'close'));

    }
    public  function getConnection()
    {
        return $this->_connection;
    }
    public  function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return mixed
     */
    public static function getInstance()
    {
        if (is_null(self::$_singleton)) {
            $class = __class__;
            self::$_singleton = new $class;
        }

        return self::$_singleton;
    }

    /**
     *
     */
    public function close() {
        ($this->_connection);
    }

    /**
     *
     */
    public function __clone()
    {
        trigger_error('It is impossible to clone singleton', E_USER_ERROR);
    }

}