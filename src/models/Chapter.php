<?php

namespace Capangas\Touchfic\models;

/**
 * Modelo da tabela tb_chapters
 */
class Chapter extends Model
{
    protected $title;
    protected $authorNotes;
    protected $content;
    protected $numberofwords;
    protected $publicationDate;
    protected $storieId;

    public function __construct($title, $authorNotes, $content, $numberofwords, $publicationDate, $storieId) {
        $this->title = $title;
        $this->authorNotes = $authorNotes;
        $this->content = $content;
        $this->numberofwords = $numberofwords;
        $this->publicationDate = $publicationDate;
        $this->storieId = $storieId;
    }

    public function save()
    {
        $statement = self::$connection->prepare('INSERT INTO tb_chapters (cha_title, cha_authornotes, cha_content, cha_numberofwords, cha_publicationdate, cha_sto_id) VALUES (:title, :authorNotes, :content, :numberofwords, :publicationDate, :stoId);');
        $statement->bindValue(
            ':title', $this->title, SQLITE3_TEXT
        );
        $statement->bindValue(
            ':authorNotes', $this->authorNotes, SQLITE3_TEXT
        );
        $statement->bindValue(
            ':content', $this->content, SQLITE3_TEXT
        );
        $statement->bindValue(
            ':numberofwords', $this->numberofwords, SQLITE3_INTEGER
        );
        $statement->bindValue(
            ':publicationDate', $this->publicationDate, SQLITE3_TEXT
        );
        $statement->bindValue(
            ':stoId', $this->storieId, SQLITE3_INTEGER
        );
        return $statement->execute();
    }
}
