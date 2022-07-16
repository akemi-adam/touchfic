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
    <title>
        Gêneros
    </title>

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
    <h1>
        Todos os gêneros:
    </h1>
    <ul>
        <?php
            $genderQuery = Gender::getConnection()->prepare('SELECT * FROM tb_genders');
            $genderResult = $genderQuery->execute();
            while ($genders = $genderResult->fetchArray()) {
                echo '<li>' . $genders['gen_gender'] . '</li>';
                echo '<form action="/admin/genders/show" method="post"><input type="hidden" class="input_delete" value="' . $genders['gen_id'] . '"></input><button class="button_delete" style="background-color: red;" onclick="remove(' . $genders['gen_id'] . ')">Remover</button></form>';
            }
        ?>
    </ul>
    <form action="/admin/genders/register" method="get">
        <button style="background-color: green;">
        Adicionar novo gênero
        </button>
    </form>
</body>
</html>