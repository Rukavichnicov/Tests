<?php

namespace App\Models;

class Db
{
    private $pdo;

    /**
     * @param $host
     * @param $user
     * @param $pass
     * @param $db
     * @return bool
     */

    public function connect($host, $user, $pass, $db)
    {
        try {
        $this->pdo =new \PDO("mysql:host=" . $host . ";dbname=" . $db, $user, $pass);
        } catch(\PDOException $exception) {
            return false;
        }
        return true;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function query($query)
    {
        return $this->pdo->query($query);
    }
}