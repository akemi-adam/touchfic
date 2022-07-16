
<!-- Importações e Verificação do formulário -->

<?php
    use Capangas\Touchfic\models\Gender;
    use Capangas\Touchfic\models\Storie;
    use Capangas\Touchfic\models\StorieOfUser;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['title'], $_POST['description'], $_POST['age_group'], $_POST['gender'], $_POST['number_of_words'])) { 

            # Salva a História
            $storie = new Storie($_POST['title'], $_POST['description'], $_POST['age_group'], $_POST['gender'], $_POST['number_of_words']);
            $storie->save();

            #Pega o último id da história
            $storieIdQuery = Storie::getConnection()->prepare('SELECT sto_id FROM tb_stories ORDER BY sto_id DESC;');
            $storieIdResult = $storieIdQuery->execute();
            $storieId = $storieIdResult->fetchArray();

            #Relaciona a história e o usuário salvando na tabela dessa combinação
            $storieOfUser = new StorieOfUser(
                $_SESSION['user_id'], $storieId['sto_id']
            );
            $storieOfUser->save();

            header('Location: /storie/show', 302);
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
    <title>
        Deixe sua imaginação fluir!
    </title>
</head>
<body>
    <h1>
        Crie uma história
    </h1>
    <form action="/storie/create" method="post">
        <label for="title">
            Título:
        </label>
        <input type="text" name="title">
        <br>
        <label for="description">Descrição:</label>
        <br>
        <textarea name="description" cols="30" rows="10">Descrição...</textarea>
        <br>
        <label for="age_group">Faixa etária:</label>
        <select name="age_group">
            <option value="L">Livre</option>
            <option value="10">10</option>
            <option value="12">12</option>
            <option value="14">14</option>
            <option value="16">16</option>
            <option value="18">18</option>
        </select>
        <label for="gender">Gênero:</label>
        <select name="gender">
            <?php
                $genderQuery = Gender::getConnection()->prepare('SELECT * FROM tb_genders');
                $genderResult = $genderQuery->execute();
                while ($genders = $genderResult->fetchArray()) {
                    echo '<option value="' . $genders['gen_id'] . '">' . $genders['gen_gender'] . '</option>';
                }
            ?>
        </select>
        <input type="hidden" name="number_of_words" value="0">
        <br>
        <button style="background-color: green;">
            Enviar
        </button>
    </form>
</body>
</html>