<?php

    #Importações

    use Capangas\Touchfic\models\Chapter;

    #Resgata os ids armazenados na session

    $storieId = $_SESSION['storie_id'];
    $chapterId = $_SESSION['chapter_id'];

    #Recupera o capítulo do banco

    $chapterQuery = Chapter::getConnection()->prepare('SELECT cha_title, cha_authornotes, cha_content, cha_numberofwords, cha_publicationdate FROM tb_chapters WHERE cha_id = :chapterId AND cha_sto_id = :storieId;');
    $chapterQuery->bindValue(':chapterId', $chapterId, SQLITE3_INTEGER);
    $chapterQuery->bindValue(':storieId', $storieId, SQLITE3_INTEGER);
    $chapterResult = $chapterQuery->execute();
    $chapter = $chapterResult->fetchArray();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo '<title>' . $chapter['cha_title'] . '</title>' ?>
</head>
<body>
    <?php
        echo '<h1>' . $chapter['cha_title'] . '</h1>';
        echo '<small><span>Data: </span>' . $chapter['cha_publicationdate'] . ' | <span>Número de palavras: </span>' . $chapter['cha_numberofwords'] . '</small>';
        echo '<p>' . nl2br($chapter['cha_authornotes']) . '</p>';
        echo '<hr>';
        echo '<p style="text-align: justify;">' . nl2br($chapter['cha_content']) . '</p>';
    ?>
</body>
</html>