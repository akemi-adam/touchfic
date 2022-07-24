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
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/3629/3629072.png">
    <script src="https://kit.fontawesome.com/f17bb9c677.js" crossorigin="anonymous"></script>
    <style>
    <?php include __DIR__ . '../../../css/style.css'; ?>
    @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@300&family=Poppins:ital,wght@0,300;0,400;1,300&display=swap');
    </style>
    <title>
        Novo capítulo
    </title>
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
    <h1 class="title">
        Novo capítulo
    </h1>

    <div class="container-create">
        <div>
    <form action="/storie/chapter/create" method="post">
        <label for="title" class="label-tag">
            Título do capítulo
        </label>
        <input type="text" name="title" class="input-title" placeholder="Título do capítulo" autofocus>
        
        <label for="author_notes" class="label-tag">
            Notas do autor
        </label>
        <br>
        <textarea name="author_notes" id="" cols="90" rows="15" class="desc-textarea" placeholder="Escreva notas sobre este capítulo"></textarea>
        
        <label for="content" class="label-tag">
            Conteúdo
        </label>
        <br>
        <textarea name="content" id="" cols="90" rows="15" class="desc-textarea" placeholder="Escreva o conteúdo do capítulo"></textarea>
        
        <?php if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            echo '<input type="hidden" name="storie_id" value="' . $_GET['id'] . '">';
        }
        ?>
        <div class="container-submit">
            <div class="submit-story-button">
                <button>
                    Enviar
                </button>
            </div>
        </div>
    </form>
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