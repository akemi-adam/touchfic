<?php

namespace Capangas\Touchfic\models;

/**
 * Modelo da tabela usuário
 */
class User extends Model
{
    protected $username;
    protected $email;
    protected $password;

    public function __construct($username, $email, $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function save()
    {
        $statement = self::$connection->prepare(
            'INSERT INTO tb_users(use_username, use_email, use_password) VALUES (:username, :email, :password);'
        );
        $statement->bindValue(
            ':username', $this->username, SQLITE3_TEXT
        );
        $statement->bindValue(
            ':email', $this->email, SQLITE3_TEXT
        );
        $statement->bindValue(
            ':password', $this->password, SQLITE3_TEXT
        );

        return $statement->execute();
    }

    public static function exists($username, $password)
    {
        $statement = self::$connection->prepare(
            'SELECT * FROM tb_users WHERE use_username = :user;'
        );
        $statement->bindValue(
            ':user', $username, SQLITE3_TEXT
        );
        $queryResult = $statement->execute();
        $row = $queryResult->fetchArray();
        if (isset($row)) {
            return password_verify($password, $row['use_password']) ? true : false;
        }
        return false;
    }

}
