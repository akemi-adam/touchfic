<?php
    if (!($_SESSION['user'] === "admin")) {
        header('Location: /dashboard', 302);
        exit;
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
    <?php include __DIR__ . '/../css/style.css'; ?>
    @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@300&family=Poppins:ital,wght@0,300;0,400;1,300&display=swap');
    </style>
    <title>
        Opções de administrador
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
        Opções de administrador
    </h1>

    <div class="container-options">
        <div class="div-options">
    <ul>
        <li>
            <a href="/admin/genders/register">Registrar novo gênero literário</a>
        </li>
        <li>
            <a href="/admin/genders/show">Visualizar todos os gêneros</a>
        </li>
    </ul>
    </div>
    </div>

</body>
</html>