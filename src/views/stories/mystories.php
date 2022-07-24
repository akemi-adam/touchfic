
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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/3629/3629072.png">
    <script src="https://kit.fontawesome.com/f17bb9c677.js" crossorigin="anonymous"></script>
    <style>
    <?php include __DIR__ . '../../css/style.css'; ?>
    @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@300&family=Poppins:ital,wght@0,300;0,400;1,300&display=swap');
    </style>
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
        Lista das minhas histórias
    </h1>

    <div class="container-stories">
    <div class="div-stories">
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
                echo '<strong>' . $stories['sto_agegroup'] . '</strong>';

                #Redireciona para a página da história

                echo '<form action="/storie/profile" method="get">';
                echo '<input type="hidden" name="title" value="' . $stories['sto_title'] . '">';
                echo '<input type="hidden" name="description" value="' . $stories['sto_description'] . '">';
                echo '<input type="hidden" name="agegroup" value="' . $stories['sto_agegroup'] . '">';
                echo '<input type="hidden" name="number_of_words" value="' . $stories['sto_numberofwords'] . '">';
                echo '<input type="hidden" name="storie_id" value="' . $stories['sto_id'] . '">';
                echo '<button style="background-color: #9c3587; color: white; font-size: 12pt; font-family: Franklin Gothic Medium; border-radius: 7px; border: none; padding: 5px; font-weight: bold; margin-bottom: 1%">Visualizar</button>';
                echo '</form>';

                #Deleta a história

                echo '<form action="/storie/mystories" method="post"> <input type="hidden" class="input_delete" value="' . $stories['sto_id'] . '"> <button style="background-color: rgb(192, 49, 49); color: white; font-size: 12pt; font-family: Franklin Gothic Medium; border-radius: 7px; border: none; padding: 5px; font-weight: bold;" onclick="remove(' . $stories['sto_id'] . ')">Excluir</button> </form>';
            } 
        }
    ?>
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