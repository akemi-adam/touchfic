<?php
    
    use Capangas\Touchfic\models\Post;
    use Capangas\Touchfic\models\User;
    use Capangas\Touchfic\models\Model;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['deleted_post'])) {
            Model::delete("tb_posts", "pos_id", $_POST['deleted_post']);
        }
    }
?>

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
        Postagens
    </title>
    <script>
            var buttonsDelete = document.getElementsByClassName("button_delete"); 
            function remove(id) {
                for (let index = 0; index < buttonsDelete.length; index++) {
                    if (buttonsDelete[index].value == id) {
                        buttonsDelete[index].setAttribute("name", "deleted_post")
                    }
                }
            }
    </script>
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
        Todas as postagens
    </h1>

    <div class="container-posts">
        <div class="div-posts">
    <?php
        $postQuery = Post::getConnection()->prepare('SELECT * FROM tb_posts');
        $postResult = $postQuery->execute();
    
        $userQuery = User::getConnection()->prepare('SELECT use_id, use_username FROM tb_users');
        $userResult = $userQuery->execute();

        while ($posts = $postResult->fetchArray()) {

            echo '<p> ' . $posts['pos_content'] . '</p>';
            echo '<small>' . $posts['pos_publicationdate'] . '</small>';

            while ($users = $userResult->fetchArray()) {
                if ($posts['pos_use_id'] === $users['use_id']) {
                    echo ' | <a href="#">' . $users['use_username'] . '</a>';
                    if ($users['use_username'] === $_SESSION['user']) {
                        echo '<form action="/posts/show" method="post"><input type="hidden" class="button_delete" value="' . $posts['pos_id'] . '"><button type="submit" style="background-color: rgb(192, 49, 49); color: white; font-size: 12pt; font-family: Franklin Gothic Medium; border-radius: 7px; border: none; padding: 5px; font-weight: bold;" onclick="remove(' . $posts['pos_id'] . ')">Excluir</button></form>';
                    }
                }
            }
            echo '<hr>';
        }
    ?>
    <a href="/posts/register" class="post-button">
        <i class="fa-solid fa-circle-plus"></i> Crie uma postagem
    </a>

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