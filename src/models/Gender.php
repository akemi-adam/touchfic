<?php

namespace Capangas\Touchfic\models;

/**
 * Modelo da tabela tb_genders
 */
class Gender extends Model
{
    protected $gender;

    public function __construct($gender) {
        $this->gender = $gender;
    }

    public function save()
    {
        $statement = self::$connection->prepare(
            'INSERT INTO tb_genders (gen_gender) VALUES (:gender);'
        );
        $statement->bindValue(
            ':gender', $this->gender, SQLITE3_TEXT
        );
        return $statement->execute();
    }
}
