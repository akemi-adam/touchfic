<?php

    use Capangas\Touchfic\models\Gender;
    use Capangas\Touchfic\models\Model;

    if (!($_SESSION['user'] === "admin")) {
        header('Location: /dashboard', 302);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['deleted_gender'])) {
            Model::delete("tb_genders", "gen_id", $_POST['deleted_gender']);
        }
    }

?>

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
    <title>
        Todos os gêneros
    </title>
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

    <script>
        var buttonsDelete = document.getElementsByClassName("input_delete");
        function remove(id) {
            for (let index = 0; index < buttonsDelete.length; index++) {
                if (buttonsDelete[index].value == id) {
                    buttonsDelete[index].setAttribute("name", "deleted_gender")
                }
            }
        }
    </script>
    
</head>
<body>
    <h1 class="title">
        Todos os gêneros
    </h1>
    
    <div class="container-options">
        <div class="div-options">
    <ul>
        <?php
            $genderQuery = Gender::getConnection()->prepare('SELECT * FROM tb_genders');
            $genderResult = $genderQuery->execute();
            while ($genders = $genderResult->fetchArray()) {
                echo '<li>' . $genders['gen_gender'] . '</li>';
                echo '<form action="/admin/genders/show" method="post"><input type="hidden" class="input_delete" value="' . $genders['gen_id'] . '"></input><button class="button_delete" style="background-color: rgb(192, 49, 49); color: white; font-size: 12pt; font-family: Franklin Gothic Medium; border-radius: 7px; border: none; padding: 5px; font-weight: bold;" onclick="remove(' . $genders['gen_id'] . ')">Remover</button></form>';
            }
        ?>
    </ul>
    <form action="/admin/genders/register" method="get">
        <button class="genre-button">
        Adicionar novo gênero
        </button>
    </form>
    </div>
    </div>
</body>
</html>