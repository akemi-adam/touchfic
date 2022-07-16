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
    <title>Cadastro de gênero</title>
</head>
<body>
    <h1>
        Adicione um novo gênero literário
    </h1>
    <form action="/admin/genders/register" method="post">
        <label for="gender">
            Novo gênero:
        </label>
        <input type="text" name="gender">
        <button>
            Enviar
        </button>
    </form>
</body>
</html>