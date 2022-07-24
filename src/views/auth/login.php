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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/3629/3629072.png">
    <script src="https://kit.fontawesome.com/f17bb9c677.js" crossorigin="anonymous"></script>
    <style><?php include __DIR__ . '../../css/style.css'; ?></style>
    <title>
        Login
    </title>
</head>
<body>

    <header>
        <div>
            <a href="/" class="logo"><img src="https://cdn-icons-png.flaticon.com/512/3629/3629072.png" alt="Touchfic">Touchfic</a>
        </div>
            <nav>
                <ul>
                    <li><a href="/about" class="nav-link">Sobre</a></li>
                    <li><a href="/faq" class="nav-link">FAQ</a></li>
                    <li><a href="/login" class="nav-link">Login</a></li>
                    <li><a href="/register" class="nav-link">Cadastre-se</a></li>
                </ul>
            </nav>
        </header>

    <div class=container-title>
        <h1 class="title">
            <mark>Entre com sua conta Touchfic</mark>
        </h1>
    </div>

    <div class="container-register-form">
        <div class="register-camp">
            <form action="/login" method="post">
                <label for="username">Nome de usuário</label>
                <input type="text" name="username" id="username" placeholder="Nome de usuário">

                <label for="password">Senha</label>
                <input type="password" name="password" placeholder="Senha">
                <button class="register-button">
                    Enviar
                </button>
            </form>
            <a href="/register" class="register-link">
                Ou cadastre-se grátis!
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