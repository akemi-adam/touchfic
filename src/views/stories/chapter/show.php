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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo '<title>' . $chapter['cha_title'] . '</title>' ?>
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/3629/3629072.png">
    <script src="https://kit.fontawesome.com/f17bb9c677.js" crossorigin="anonymous"></script>
    <style>
    <?php include __DIR__ . '../../../css/style.css'; ?>
    @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@300&family=Poppins:ital,wght@0,300;0,400;1,300&display=swap');
    </style>
</head>
<body>
<header>
    <div>
        <a href="/dashboard" class="logo"><img src="https://cdn-icons-png.flaticon.com/512/3629/3629072.png" alt="Touchfic">Touchfic</a>
    </div>
        <nav>
            <ul>
                <li><a href="/dashboard" class="nav-link">Página Inicial</a></li>
                <li><a href="/storie/mystories" class="nav-link">Minhas histórias</a></li>
                <li><a href="/storie/create" class="nav-link">Criar</a></li>
            </ul>
        </nav>
    </header>

    <div class="container-chapter">
        <div class="div-chapter">
    <?php
        echo '<h1 class="title">' . $chapter['cha_title'] . '</h1>';
        echo '<small class="chapter-info"><span>Data: </span>' . $chapter['cha_publicationdate'] . ' | <span>Número de palavras: </span>' . $chapter['cha_numberofwords'] . '</small>';
        echo '<p class="author-note">' . nl2br($chapter['cha_authornotes']) . '</p>';
        echo '<hr>';
        echo '<p style="text-align: justify;" class="chapter-text">' . nl2br($chapter['cha_content']) . '</p>';
    ?>
    </div>
    </div>

    <footer>
        <div>
        <p>Touchfic: crie e leia histórias com um só toque</p>
        <ul>
            <li><a href="/"><i class="fa-brands fa-instagram"></i></a></li>
            <li><a href="/"><i class="fa-brands fa-twitter"></i></a></li>
            <li><a href="/"><i class="fa-brands fa-facebook"></i></a></li>
            <li><a href="/"><i class="fa-brands fa-tiktok"></i></a></li>
            <li><a href="/"><i class="fa-brands fa-pinterest"></i></a></li>
        </ul>
        </div> 

        <div>
            <ul>
                <li><a href="">Termos de Uso</a></li>
                <li><a href="">Política de Privacidade</a></li>
            </ul>
        </div>

        <div class="div-credits">
        <a href="https://www.flaticon.com/br/icones-gratis/tocha" title="tocha ícones">Tocha ícones criados por Freepik - Flaticon</a>
        </div>
    </footer>
</body>
</html>