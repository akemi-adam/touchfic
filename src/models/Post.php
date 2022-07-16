<?php

namespace Capangas\Touchfic\models;

/**
 * Modelo para a tabela post
 */
class Post extends Model
{
    protected $content;
    protected $publicationdate;
    protected $userId;

    public function __construct($content, $publicationdate, $userId)
    {
        $this->content = $content;
        $this->publicationdate = $publicationdate;
        $this->userId = $userId;
    }

    public function save()
    {
        $statement = self::$connection->prepare(
            'INSERT INTO tb_posts (pos_content, pos_publicationdate, pos_use_id) VALUES (:content, :publicationdate, :userId);'
        );
        $statement->bindValue(
            ':content', $this->content, SQLITE3_TEXT
        );
        $statement->bindValue(
            ':publicationdate', $this->publicationdate, SQLITE3_TEXT
        );
        $statement->bindValue(
            ':userId', $this->userId, SQLITE3_INTEGER
        );
        return $statement->execute();
    }
}
