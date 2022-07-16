<?php
    if (!($_SESSION['user'] === "admin")) {
        header('Location: /dashboard', 302);
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Admin
    </title>
</head>
<body>
    <h1>
        Opções de administrador
    </h1>
    <ul>
        <li>
            <a href="/admin/genders/register">Registrar novo gênero literário</a>
        </li>
        <li>
            <a href="/admin/genders/show">Visualizar todos os gêneros</a>
        </li>
    </ul>
</body>
</html>