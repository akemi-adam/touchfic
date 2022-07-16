<?php

namespace Capangas\Touchfic\models;

/**
 * Classe do modelo
 */
abstract class Model
{
    protected static $connection;

    public static function createConnection($connection)
    {
        self::$connection = $connection;
    }

    public static function createModel($table)
    {
        self::$connection->exec($table);
    }

    public static function getConnection()
    {
        return self::$connection;
    }
    
    public static function delete($table, $collumn, $id)
    {
        $statement = self::$connection->prepare(
            "DELETE FROM $table WHERE $collumn = :id;"
        );
        $statement->bindValue(
            ':id', $id, SQLITE3_INTEGER
        );
        return $statement->execute();
    }

    public static function uptade($table, $collumn1, $value, $collumn2, $id)
    {
        $statement = self::$connection->prepare(
            "UPDATE $table SET $collumn1 = $value WHERE $collumn2 = :id"
        );
        $statement->bindValue(
            ':id', $id, SQLITE3_INTEGER
        );
        return $statement->execute();
    }
}
