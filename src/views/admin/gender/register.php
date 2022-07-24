<?php

    use Capangas\Touchfic\models\Gender;

    if (!($_SESSION['user'] === "admin")) {
        header('Location: /dashboard', 302);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['gender'])) {
            $gender = new Gender($_POST['gender']);
            $gender->save();
            header('Location: /admin/genders/show', 302);
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
    <title>Cadastro de gênero</title>
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
        Adicione um novo gênero literário
    </h1>

    <div class="container-faq">
        <div class="div-faq">
    <form action="/admin/genders/register" method="post">
        <label for="gender">
            Novo gênero
        </label>
        <input type="text" name="gender">

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

</body>
</html>