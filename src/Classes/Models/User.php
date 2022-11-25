<?php

namespace App\Models;

class User
{
    public const STATUS_WAIT = '0';
    public const STATUS_ACTIVE = '1';

    private $name;
    private $email;
    private $password;
    private $isActive;
    private $id;

    private $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
        $this->db->setConnection();
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    private function setId($id): void
    {
        $this->id = $id;
    }

    public function register($name, $email, $password)
    {
        $sql = "INSERT INTO users SET name='$name', email='$email', password='".password_hash($password, PASSWORD_BCRYPT)."';";
        $this->db->query($sql);

        $this->setId($this->db->getLastId());
        return $this->find($this->getId());
    }

    public function find($id)
    {
        $sql = "SELECT * FROM users WHERE id = '$id' LIMIT 1;";
        $result = $this->db->query($sql);

        if($result) {
            $row = $result->fetchAll();
            $this->setName($row['name']);
            $this->setPassword($row['password']);
            $this->setEmail($row['email']);
            $this->setIsActive($row['is_active']);
        }

        return $this;
    }

    public function isActive(): bool
    {
        return $this->getIsActive() === self::STATUS_ACTIVE;
    }

    public function isWait(): bool
    {
        return $this->getIsActive() === self::STATUS_WAIT;
    }

     public function verify(): void
     {
         if (!$this->isWait()) {
             throw new \Exception('User verified');
         }

         $sql = "UPDATE users SET is_active='".self::STATUS_ACTIVE."' WHERE id = '$this->id';";
         $this->db->query($sql);

         $this->setIsActive(self::STATUS_ACTIVE);
     }
}