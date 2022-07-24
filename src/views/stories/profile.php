<?php

    #Importações

    use Capangas\Touchfic\models\StorieOfUser;
    use Capangas\Touchfic\models\Chapter;
    use Capangas\Touchfic\models\Storie;
    use Capangas\Touchfic\models\User;

    #Deleta o capítulo

    $subtracted = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['deleted_chapter'])) {
            Storie::uptade('tb_stories', 'sto_numberofwords', $_POST['number_of_words'] - $_POST['chapterWords'], 'sto_id', $_POST['storie_id']);
            $subtracted = true;
            $newWordsNumber = $_POST['number_of_words'] - $_POST['chapterWords'];
            Chapter::delete("tb_chapters", "cha_id", $_POST['deleted_chapter']);
        }
    }

    $storieId = ($_SERVER['REQUEST_METHOD'] === 'GET') ? $_GET['storie_id'] : $_POST['storie_id'];

    $storieOfUserQuery = StorieOfUser::getConnection()->prepare('SELECT sus_use_id FROM tb_storiesofusers WHERE sus_sto_id = :storieId AND sus_use_id = :userId');
    $storieOfUserQuery->bindValue(
        ':storieId', $storieId, SQLITE3_INTEGER
    );
    $storieOfUserQuery->bindValue(
        ':userId', $_SESSION['user_id'], SQLITE3_INTEGER
    );
    $storieOfUserResult = $storieOfUserQuery->execute();
    $storieOfUser = $storieOfUserResult->fetchArray();

    $writer = false;

    if (isset($storieOfUser['sus_use_id'])) {
        $writer = true;
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
    <?php
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            echo '<title>' . $_GET['title'] . '</title>';
        }
        elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
            echo '<title>' . $_POST['title'] . '</title>';
        }
    ?>

    <!-- Função auxiliar para deletar um capítulo -->
    <script>
        var buttonsDelete = document.getElementsByClassName("input_delete");
        function remove(id) {
            for (let index = 0; index < buttonsDelete.length; index++) {
                if (buttonsDelete[index].value == id) {
                    buttonsDelete[index].setAttribute("name", "deleted_chapter")
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

    <div class="container-story">
        <div class="div-story">
    <?php

        #Informações sobre a história
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            echo '<h1 class="title">' . $_GET['title'] . '</h1>';
            echo '<p>' . $_GET['description'] . '</p>';
            echo '<hr>';
            echo '<p>Classificação indicativa: ' . $_GET['agegroup'] . '</p>';
            if (!$subtracted) {
                echo '<p>Número de palavras: ' . $_GET['number_of_words'] . '</p>';
            } else {
                echo '<p>Número de palavras: ' . $newWordsNumber . '</p>';
            }
            
        }
        elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
            echo '<h1>' . $_POST['title'] . '</h1>';
            echo '<p>' . $_POST['description'] . '</p>';
            echo '<hr>';
            echo '<p>Classificação etária:' . $_POST['agegroup'] . '</p>';
            if (!$subtracted) {
                echo '<p>Número de palavras: ' . $_POST['number_of_words'] . '</p>';
            } else {
                echo '<p>Número de palavras: ' . $newWordsNumber . '</p>';
            }
            
        }
        if ($writer) {
            echo '<form action="/storie/chapter/create" method="get">';
            echo '<input type="hidden" name="id" value="' . $storieId . '">';
            echo '<button style="background-color: #9c3587; color: white; font-size: 12pt; font-family: Franklin Gothic Medium; border-radius: 7px; border: none; padding: 5px; font-weight: bold; margin-bottom: 1%">Criar capítulo</button>';
            echo '</form>';
        }
    ?>
    <h3 class="chapters">
        Capítulos:
    </h3>
    <ul>
        <?php

            #Recupera os capítulos da história no banco

            $chapterQuery = Chapter::getConnection()->prepare('SELECT cha_title, cha_publicationdate, cha_numberofwords, cha_id FROM tb_chapters WHERE cha_sto_id = :sto_id');
            if ($_SERVER['REQUEST_METHOD'] === "GET") {
                $chapterQuery->bindValue(
                    ':sto_id', $_GET['storie_id'], SQLITE3_INTEGER
                );
            }
            elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
                $chapterQuery->bindValue(
                    ':sto_id', $_POST['storie_id'], SQLITE3_INTEGER
                );
            }
            $chapterResult = $chapterQuery->execute();

            while ($chapters = $chapterResult->fetchArray()) {

                #Listagem de informações sobre o capítulo

                echo '<li><strong>' . $chapters['cha_title'] . '</strong><span> | Número de palavras: ' . $chapters['cha_numberofwords'] . ' | Data: ' . $chapters['cha_publicationdate'] . '</span></li>';

                #Visualiza o capítulo

                echo '<form action="/storie/chapter/show-aux" method="post">';
                echo '<input type="hidden" name="chapterId" value="' . $chapters['cha_id'] . '"><input type="hidden" name="storieId" value="' . $storieId . '">';
                echo '<button style="background-color: #9c3587; color: white; font-size: 12pt; font-family: Franklin Gothic Medium; border-radius: 7px; border: none; padding: 5px; font-weight: bold; margin-bottom: 1%" >Visualizar</button>';
                echo'</form>';

                if ($writer) {

                    #Reenviar as informações da página caso delete algum capítulo

                    echo '<form action="/storie/profile" method="post">';

                    if ($_SERVER['REQUEST_METHOD'] === "GET") {
                        echo '<input type="hidden" name="title" value="' . $_GET['title'] . '">';
                        echo '<input type="hidden" name="description" value="' . $_GET['description'] . '">';
                        echo '<input type="hidden" name="agegroup" value="' . $_GET['agegroup'] . '">';
                        echo '<input type="hidden" name="number_of_words" value="' . $_GET['number_of_words'] . '">';
                        echo '<input type="hidden" name="storie_id" value="' . $_GET['storie_id'] . '">';
                        echo '<input type="hidden" name="chapterWords" value="' . $chapters['cha_numberofwords'] . '">';
                    }
                    elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
                        echo '<input type="hidden" name="title" value="' . $_POST['title'] . '">';
                        echo '<input type="hidden" name="description" value="' . $_POST['description'] . '">';
                        echo '<input type="hidden" name="agegroup" value="' . $_POST['agegroup'] . '">';
                        echo '<input type="hidden" name="number_of_words" value="' . $_POST['number_of_words'] . '">';
                        echo '<input type="hidden" name="storie_id" value="' . $_POST['storie_id'] . '">';
                        echo '<input type="hidden" name="chapterWords" value="' . $chapters['cha_numberofwords'] . '">';
                    }

                    #Deleta o capítulo respectivo
                
                    echo '<input class="input_delete" type="hidden" value="' . $chapters['cha_id'] . '">';
                    echo '<button style="background-color: rgb(192, 49, 49); color: white; font-size: 12pt; font-family: Franklin Gothic Medium; border-radius: 7px; border: none; padding: 5px; font-weight: bold;" onclick="remove(' . $chapters['cha_id'] . ')">Excluir</button>';

                    echo '</form>';
                }

            }

        ?>
    </ul>
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