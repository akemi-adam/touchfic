<?php
    use Capangas\Touchfic\app\AuthMiddleware;
    use Capangas\Touchfic\models\User;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST['username'], $_POST['password'])) {
    
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            if (User::exists($username, $password)) {
    
                //iniciar sessão
                session_start();
                $_SESSION['user'] = $username;
                $_SESSION['id'] = session_id() . $username;
                $sttm = User::getConnection()->prepare('SELECT use_id FROM tb_users WHERE use_username = :username');
                $sttm->bindValue(':username', $username, SQLITE3_TEXT);
                $result = $sttm->execute();
                $id = $result->fetchArray();
                $_SESSION['user_id'] = $id['use_id'];
                header("Location: /dashboard");
                exit;
            } else {
                header("Location: /login", 302);
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
        Login
    </title>
</head>
<body>
    <h1>
        Faça login
    </h1>
    <form action="/login" method="post">
        <input type="text" name="username" id="username" placeholder="Nome de usuário">
        <input type="password" name="password">
        <button>
            Enviar
        </button>
    </form>
    <a href="/register">
        Registre-se
    </a>
</body>
</html>