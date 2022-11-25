<?php

namespace App\Models;

class Db
{
    private static $instance;
    private $pdo;

    public static function getInstance()
    {
        if(self::$instance instanceof static) {
            return self::$instance;
        }
        return  self::$instance = new static();
    }

    private function __construct()
    {

    }

    /**
     * @param $host
     * @param $user
     * @param $pass
     * @param $dbname
     */

    public function setConnection()
    {
        try {
            $this->pdo = new \PDO(
                'mysql::memory:'
            );
        } catch (\PDOException $exception) {
        }
    }

    public function query($sql)
    {
        $sth = $this->pdo->prepare($sql);
        return $sth->execute();
    }

    public function getLastId()
    {
        return $this->pdo->lastInsertId();
    }

    public function getInsDb()
    {
        return $this->pdo;
    }
}