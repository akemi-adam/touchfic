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

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Postagens!
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
    <h1>
        Todas as postagens:
    </h1>
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
                        echo '<form action="/posts/show" method="post"><input type="hidden" class="button_delete" value="' . $posts['pos_id'] . '"><button type="submit" onclick="remove(' . $posts['pos_id'] . ')">Deletar</button></form>';
                    }
                }
            }
            echo '<hr>';
        }
    ?>
    <br>
    <br>
    <a href="/posts/register">
        Quer fazer uma postagem? Clica aqui!
    </a>
    <br>
    <a href="/dashboard">
        Página inicial
    </a>
    <form action="/logout" method="post">
        <button>
            Sair
        </button>
    </form>
</body>
</html>