
<!-- Importações -->

<?php

    use Capangas\Touchfic\models\Storie;
    use Capangas\Touchfic\models\User;
    use Capangas\Touchfic\models\StorieOfUser;
    use Capangas\Touchfic\models\Chapter;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['deleted_storie'])) {
            Storie::delete("tb_stories", "sto_id", $_POST['deleted_storie']);
            Chapter::delete("tb_chapters", "cha_sto_id", $_POST['deleted_storie']);
            StorieOfUser::delete("tb_storiesofusers", "sus_sto_id", $_POST['deleted_storie']);
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas histórias</title>
    <script>
        var buttonsDelete = document.getElementsByClassName("input_delete");
        function remove(id) {
            for (let index = 0; index < buttonsDelete.length; index++) {
                if (buttonsDelete[index].value == id) {
                    buttonsDelete[index].setAttribute("name", "deleted_storie")
                }
            }
        }
    </script>
</head>
<body>
    <h1>
        Lista das minhas histórias
    </h1>
    <?php

        #Pega os ids das histórias que o usuário criou
        $storieIdQuery = StorieOfUser::getConnection()->prepare('SELECT sus_sto_id FROM tb_storiesofusers WHERE sus_use_id = :user_id');
        $storieIdQuery->bindValue(':user_id', $_SESSION['user_id'], SQLITE3_INTEGER);
        $storieIdResult = $storieIdQuery->execute();

        #Exibe-as
        while ($storiesId = $storieIdResult->fetchArray()) {
            $storieQuery = Storie::getConnection()->prepare('SELECT sto_title, sto_description, sto_agegroup, sto_id, sto_numberofwords FROM tb_stories WHERE sto_id = :sus_sto_id');
            $storieQuery->bindValue(':sus_sto_id', $storiesId['sus_sto_id'], SQLITE3_INTEGER);
            $storieResult = $storieQuery->execute();
            while ($stories = $storieResult->fetchArray()) {
                
                #Mostra detalhes da história

                echo '<h3>' . $stories['sto_title'] . '</h3>';
                echo '<p>' . $stories['sto_description'] . '</p>';
                echo '<br><strong>' . $stories['sto_agegroup'] . '</strong>';

                #Redireciona para a página da história

                echo '<form action="/storie/profile" method="get">';
                echo '<input type="hidden" name="title" value="' . $stories['sto_title'] . '">';
                echo '<input type="hidden" name="description" value="' . $stories['sto_description'] . '">';
                echo '<input type="hidden" name="agegroup" value="' . $stories['sto_agegroup'] . '">';
                echo '<input type="hidden" name="number_of_words" value="' . $stories['sto_numberofwords'] . '">';
                echo '<input type="hidden" name="storie_id" value="' . $stories['sto_id'] . '">';
                echo '<button>Visualizar</button>';
                echo '</form>';

                #Deleta a história

                echo '<form action="/storie/mystories" method="post"> <input type="hidden" class="input_delete" value="' . $stories['sto_id'] . '"> <button style="background-color: red;" onclick="remove(' . $stories['sto_id'] . ')">Excluir</button> </form>';
            } 
        }
    ?>
</body>
</html>