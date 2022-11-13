<?php

namespace App\Models;

class User
{
    private $name;
    private $email;
    private $password;
    private $age;

    /**
     * @param $name
     * @param $email
     * @param $password
     * @param $age
     */
    public function __construct($name = null, $email = null, $password = null, $age = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->age = $age;
    }

    /**
     * @return mixed
     */public function getName()
    {
        return $this->name;
    }
    /**
     * @param mixed $name
     */public function setName($name): void
    {
        $this->name = $name;
    }
    /**
     * @return mixed
     */public function getEmail()
    {
        return $this->email;
    }
    /**
     * @param mixed $email
     */public function setEmail($email): void
    {
        $this->email = $email;
    }
    /**
     * @return mixed
     */public function getPassword()
    {
        return $this->password;
    }
    /**
     * @param mixed $password
     */public function setPassword($password): void
    {
        $this->password = $password;
    }
    /**
     * @return mixed
     */public function getAge()
    {
        return $this->age;
    }
    /**
     * @param mixed $age
     */public function setAge($age): void
    {
        $this->age = $age;
    }
}