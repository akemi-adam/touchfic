<?php

namespace Capangas\Touchfic\models;

/**
 * Modelo da tabela tb_stories
 */
class Storie extends Model
{
    protected $title;
    protected $description;
    protected $ageGroup;
    protected $gender;
    protected $numberOfWords;

    public function __construct($title, $description, $ageGroup, $gender, $numberOfWords)
    {
        $this->title = $title;
        $this->description = $description;
        $this->ageGroup = $ageGroup;
        $this->gender = $gender;
        $this->numberOfWords = $numberOfWords;
    }

    public function save()
    {
        $statement = self::$connection->prepare(
            'INSERT INTO tb_stories (sto_title, sto_description, sto_agegroup, sto_gen_id, sto_numberofwords) VALUES (:title, :description, :ageGroup, :genderId, :numberOfWords);'
        );
        $statement->bindValue(
            ':title', $this->title, SQLITE3_TEXT
        );
        $statement->bindValue(
            ':description', $this->description, SQLITE3_TEXT
        );
        $statement->bindValue(
            ':ageGroup', $this->ageGroup, SQLITE3_TEXT
        );
        $statement->bindValue(
            ':genderId', $this->gender, SQLITE3_INTEGER
        );
        $statement->bindValue(
            ':numberOfWords', $this->numberOfWords, SQLITE3_INTEGER
        );
        return $statement->execute();
    }
}
