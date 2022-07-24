<?php

    use Capangas\Touchfic\models\Post;
    use Capangas\Touchfic\models\User;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['content'])) {
            $statement = User::getConnection()->prepare(
                'SELECT use_id FROM tb_users WHERE use_username = :username'
            );
            $statement->bindValue(
                ':username', $_SESSION['user'], SQLITE3_TEXT
            );
            $result = $statement->execute();
            while ($idArray = $result->fetchArray()) {
                $userId = $idArray['use_id'];
            }
            $post = new Post(
                $_POST['content'], str_replace("/", '-', date('Y/m/j')), $userId
            );
            $post->save();
            header('Location: /posts/show', 302);
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/3629/3629072.png">
    <script src="https://kit.fontawesome.com/f17bb9c677.js" crossorigin="anonymous"></script>
    <style>
    <?php include __DIR__ . '../../css/style.css'; ?>
    @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@300&family=Poppins:ital,wght@0,300;0,400;1,300&display=swap');
    </style>
    <title>
        Criar postagem
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
        Publique uma postagem!
    </h1>

    <div class="container-textarea">
        <div class="div-textarea">
            <form action="/posts/register" method="post">
                <textarea name="content" id="content" cols="60" rows="10" placeholder="No que você está pensando?" autofocus></textarea>
                <div class="container-submit">
                    <button class="submit-button">
                        Enviar
                    </button>
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