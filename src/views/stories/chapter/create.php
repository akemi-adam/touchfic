<?php

    #Importações

    use Capangas\Touchfic\models\Chapter;
    use Capangas\Touchfic\models\Storie;

    #Salva um capítulo no banco
    
    if ($_SERVER['REQUEST_METHOD']) {
        if (isset($_POST['title'], $_POST['author_notes'], $_POST['content'], $_POST['storie_id'])) {
            $chapter = new Chapter(
                $_POST['title'], $_POST['author_notes'], $_POST['content'], count(preg_split('~[^\p{L}\p{N}\']+~u', $_POST['content'])), str_replace("/", '-', date('Y/m/j')), $_POST['storie_id']
            );
            $chapter->save();

            #Atualiza a quantidade de palavras da história

            $storieQuery = Storie::getConnection()->prepare('SELECT sto_numberofwords, sto_id FROM tb_stories WHERE sto_id = :storie_id');
            $storieQuery->bindValue(':storie_id', $_POST['storie_id'], SQLITE3_INTEGER);
            $storieResult = $storieQuery->execute();
            $storie = $storieResult->fetchArray();
            $words = count(preg_split('~[^\p{L}\p{N}\']+~u', $_POST['content'])) + $storie['sto_numberofwords'];
            Storie::uptade("tb_stories", "sto_numberofwords", $words, "sto_id", $_POST['storie_id']);

            #Redireciona a página para a visualização do capítulo
            
            $chapterIdQuery = Chapter::getConnection()->prepare('SELECT cha_id FROM tb_chapters WHERE cha_sto_id = :storieId ORDER BY cha_id DESC;');
            $chapterIdQuery->bindValue(':storieId', $_POST['storie_id'], SQLITE3_INTEGER);
            $chapterIdResult = $chapterIdQuery->execute();
            $chapterId = $chapterIdResult->fetchArray();

            $_SESSION['storie_id'] = $_POST['storie_id'];
            $_SESSION['chapter_id'] = $chapterId['cha_id'];

            header('Location: /storie/chapter/show', 302);
            exit;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Crie um capítulo!
    </title>
</head>
<body>
    <h1>
        Novo capítulo
    </h1>
    <form action="/storie/chapter/create" method="post">
        <label for="title">
            Título:
        </label>
        <input type="text" name="title">
        <br>
        <label for="author_notes">
            Notas do autor:
        </label>
        <br>
        <textarea name="author_notes" id="" cols="30" rows="10"></textarea>
        <br>
        <label for="content">
            Conteúdo:
        </label>
        <br>
        <textarea name="content" id="" cols="50" rows="10"></textarea>
        <br>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            echo '<input type="hidden" name="storie_id" value="' . $_GET['id'] . '">';
        }
        ?>
        <button>Enviar</button>
    </form>
</body>
</html>