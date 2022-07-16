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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        O que está pensando?
    </title>
</head>
<body>
    <h1>
        Faça uma postagem!
    </h1>
    <form action="/posts/register" method="post">
        <textarea name="content" id="content" cols="40" rows="10">O que você está pensando?</textarea>
        <br>
        <button>
            Enviar
        </button>
    </form>

</body>
</html>