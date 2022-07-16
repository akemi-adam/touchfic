<?php
    use Capangas\Touchfic\models\User;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['username'], $_POST['email'], $_POST['password'])) {
            $user = new User(
                $_POST['username'], $_POST['email'], $_POST['password']
            );
            if (!User::exists($_POST['username'], $_POST['password'])) {
                $user->save();
                session_start();
                $_SESSION['user'] = $_POST['username'];
                $_SESSION['id'] = session_id() . $_POST['username'];
                $sttm = User::getConnection()->prepare('SELECT use_id FROM tb_users WHERE use_username = :username');
                $sttm->bindValue(':username', $_SESSION['user'], SQLITE3_TEXT);
                $result = $sttm->execute();
                $id = $result->fetchArray();
                $_SESSION['user_id'] = $id['use_id'];
                header('Location: /dashboard', true, 302);
                exit;
            }
            else {
                header('Location: /login', true, 302);
                exit;
            }
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
        Cadastro
    </title>
</head>
<body>
    <h1>
        Crie uma conta!
    </h1>
    <form action="/register" method="post">
        <label for="username">
            Nome de usuário:
        </label>
        <input type="text" name="username">
        <br>
        <label for="email">
            E-mail:
        </label>
        <input type="email" name="email">
        <br>
        <label for="password">
            Senha
        </label>
        <input type="password" name="password">
        <br>
        <button>
            Enviar
        </button>
    </form>
</body>
</html>