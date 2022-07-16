<?php

namespace Capangas\Touchfic\models;

/**
 * Modelo da classe tb_storiesofusers
 */
class StorieOfUser extends Model
{
    protected $useId;
    protected $stoId;

    public function __construct($useId, $stoId) {
        $this->useId = $useId;
        $this->stoId = $stoId;
    }

    public function save()
    {
        $statement = self::$connection->prepare(
            'INSERT INTO tb_storiesofusers (sus_use_id, sus_sto_id) VALUES (:use_id, :sto_id);'
        );
        $statement->bindValue(
            ':use_id', $this->useId, SQLITE3_INTEGER
        );
        $statement->bindValue(
            'sto_id', $this->stoId, SQLITE3_INTEGER
        );
        return $statement->execute();
    }
}
